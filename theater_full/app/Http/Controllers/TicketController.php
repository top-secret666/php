<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Models\PriceTier;

class TicketController extends Controller
{
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
        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(StoreTicketRequest $request, Ticket $ticket)
    {
        $data = $request->validated();
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
        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
