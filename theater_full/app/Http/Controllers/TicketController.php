<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Models\PriceTier;
use App\Services\PerformanceStatsUpdater;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        // Ticket purchase requires login.
        $this->middleware('auth');
        // Listing all tickets is admin-only.
        $this->middleware('admin')->only(['index']);
    }

    public function index(Request $request)
    {
        $tickets = Ticket::with(['performance','seat'])->paginate(30);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();
        if (!$user?->is_admin) {
            // bind ticket to the purchaser
            $data['purchaser_id'] = $user->id;
        }

        // if a price_tier_id was provided, resolve its price
        if (isset($data['price_tier_id'])) {
            $tier = PriceTier::find($data['price_tier_id']);
            if ($tier) {
                // price_tiers store amount in cents
                $data['price'] = isset($tier->amount_cents) ? ($tier->amount_cents / 100) : null;
            }
        }
        // generate qr_code immediately when ticket is sold
        if (isset($data['status']) && $data['status'] === 'sold' && empty($data['qr_code'])) {
            $data['qr_code'] = bin2hex(random_bytes(8));
        }

        $ticket = Ticket::create($data);

        app(PerformanceStatsUpdater::class)->update($ticket, null);
        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $original = $ticket->replicate();
        $data = $request->validated();

        $user = $request->user();
        if (!$user?->is_admin) {
            // prevent tampering
            $data['purchaser_id'] = $user->id;
            // order_id can only be set to user's own order
            if (isset($data['order_id'])) {
                $order = \App\Models\Order::find($data['order_id']);
                if (!$order || (int) $order->user_id !== (int) $user->id) {
                    unset($data['order_id']);
                }
            }
        }

        // if price_tier_id provided during update, resolve price
        if (isset($data['price_tier_id'])) {
            $tier = PriceTier::find($data['price_tier_id']);
            if ($tier) {
                $data['price'] = isset($tier->amount_cents) ? ($tier->amount_cents / 100) : null;
            }
        }
        // if marking as sold, ensure qr_code exists
        if (isset($data['status']) && $data['status'] === 'sold' && empty($ticket->qr_code)) {
            $data['qr_code'] = $ticket->qr_code ?? bin2hex(random_bytes(8));
        }

        $ticket->update($data);
        app(PerformanceStatsUpdater::class)->update($ticket, $original);
        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);
        $ticket->delete();
        // For regular users, redirect to cart; for admins, to the tickets list.
        return Auth::user()?->is_admin
            ? redirect()->route('tickets.index')
            : redirect()->route('cart.index');
    }

    private function authorizeTicketAccess(Ticket $ticket): void
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->is_admin) {
            return;
        }

        $ownsByPurchaser = (int) ($ticket->purchaser_id ?? 0) === (int) $user->id;
        $ownsByOrder = $ticket->order && (int) ($ticket->order->user_id ?? 0) === (int) $user->id;

        if (!$ownsByPurchaser && !$ownsByOrder) {
            abort(403);
        }
    }
}
