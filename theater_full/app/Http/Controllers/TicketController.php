<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Models\PriceTier;
use App\Models\PerformanceStat;
use Illuminate\Support\Carbon;

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
        $this->updatePerformanceStats($ticket, null);
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
        $original = $ticket->replicate();
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
        $this->updatePerformanceStats($ticket, $original);
        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }

    private function updatePerformanceStats(Ticket $ticket, ?Ticket $original): void
    {
        $today = Carbon::today();

        $newPerformanceId = $ticket->performance_id;
        $oldPerformanceId = $original?->performance_id;

        $newStatus = $ticket->status;
        $oldStatus = $original?->status;

        $newCheckedIn = $ticket->checked_in_at;
        $oldCheckedIn = $original?->checked_in_at;

        $newPrice = (float) ($ticket->price ?? 0);
        $oldPrice = (float) ($original?->price ?? 0);

        // Handle status transitions affecting sold count and revenue
        if ($original === null) {
            if ($newStatus === 'sold') {
                $this->applyStatsDelta($newPerformanceId, $today, 1, $newPrice, 0);
            }
            if (!empty($newCheckedIn)) {
                $this->applyStatsDelta($newPerformanceId, $today, 0, 0, 1);
            }
            return;
        }

        // Performance changed: remove from old, add to new
        if ($oldPerformanceId && $newPerformanceId && $oldPerformanceId !== $newPerformanceId) {
            if ($oldStatus === 'sold') {
                $this->applyStatsDelta($oldPerformanceId, $today, -1, -$oldPrice, $oldCheckedIn ? -1 : 0);
            }
            if ($newStatus === 'sold') {
                $this->applyStatsDelta($newPerformanceId, $today, 1, $newPrice, $newCheckedIn ? 1 : 0);
            }
            return;
        }

        // Same performance: handle sold status change
        if ($oldStatus !== $newStatus) {
            if ($oldStatus === 'sold' && $newStatus !== 'sold') {
                $this->applyStatsDelta($newPerformanceId, $today, -1, -$oldPrice, 0);
            }
            if ($oldStatus !== 'sold' && $newStatus === 'sold') {
                $this->applyStatsDelta($newPerformanceId, $today, 1, $newPrice, 0);
            }
        }

        // If sold and price changed, adjust revenue
        if ($newStatus === 'sold' && $newPrice !== $oldPrice) {
            $this->applyStatsDelta($newPerformanceId, $today, 0, $newPrice - $oldPrice, 0);
        }

        // checked-in transitions
        if (empty($oldCheckedIn) && !empty($newCheckedIn)) {
            $this->applyStatsDelta($newPerformanceId, $today, 0, 0, 1);
        } elseif (!empty($oldCheckedIn) && empty($newCheckedIn)) {
            $this->applyStatsDelta($newPerformanceId, $today, 0, 0, -1);
        }
    }

    private function applyStatsDelta(int $performanceId, Carbon $date, int $soldDelta, float $revenueDelta, int $checkedInDelta): void
    {
        $stat = PerformanceStat::firstOrCreate(
            [
                'performance_id' => $performanceId,
                'date_calculated' => $date,
            ],
            [
                'tickets_sold' => 0,
                'revenue' => 0,
                'checked_in_count' => 0,
            ]
        );

        $stat->tickets_sold += $soldDelta;
        $stat->revenue = (float) $stat->revenue + $revenueDelta;
        $stat->checked_in_count += $checkedInDelta;
        $stat->save();
    }
}
