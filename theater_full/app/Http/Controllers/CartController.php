<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Services\PerformanceStatsUpdater;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $tickets = Ticket::query()
            ->with(['performance.show', 'seat'])
            ->where('purchaser_id', $user->id)
            ->whereNull('order_id')
            ->where('status', 'reserved')
            ->orderByDesc('id')
            ->get();

        $total = (float) $tickets->sum('price');

        return view('cart.index', compact('tickets', 'total'));
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();

        $tickets = Ticket::query()
            ->where('purchaser_id', $user->id)
            ->whereNull('order_id')
            ->where('status', 'reserved')
            ->lockForUpdate()
            ->get();

        if ($tickets->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => (float) $tickets->sum('price'),
            'status' => 'pending',
        ]);

        $updater = app(PerformanceStatsUpdater::class);

        foreach ($tickets as $ticket) {
            $original = $ticket->replicate();

            $ticket->order_id = $order->id;
            $ticket->status = 'sold';
            $ticket->issued_at = Carbon::now();
            if (empty($ticket->qr_code)) {
                $ticket->qr_code = bin2hex(random_bytes(8));
            }
            $ticket->save();

            $updater->update($ticket, $original);
        }

        return redirect()->route('orders.show', $order);
    }
}
