<?php

namespace App\Services;

use App\Models\PerformanceStat;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

class PerformanceStatsUpdater
{
    public function update(Ticket $ticket, ?Ticket $original): void
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

        // Handle create
        if ($original === null) {
            if ($newStatus === 'sold') {
                $this->applyDelta($newPerformanceId, $today, 1, $newPrice, 0);
            }
            if (!empty($newCheckedIn)) {
                $this->applyDelta($newPerformanceId, $today, 0, 0, 1);
            }
            return;
        }

        // Performance changed: remove from old, add to new
        if ($oldPerformanceId && $newPerformanceId && $oldPerformanceId !== $newPerformanceId) {
            if ($oldStatus === 'sold') {
                $this->applyDelta($oldPerformanceId, $today, -1, -$oldPrice, $oldCheckedIn ? -1 : 0);
            }
            if ($newStatus === 'sold') {
                $this->applyDelta($newPerformanceId, $today, 1, $newPrice, $newCheckedIn ? 1 : 0);
            }
            return;
        }

        // Same performance: handle sold status change
        if ($oldStatus !== $newStatus) {
            if ($oldStatus === 'sold' && $newStatus !== 'sold') {
                $this->applyDelta($newPerformanceId, $today, -1, -$oldPrice, 0);
            }
            if ($oldStatus !== 'sold' && $newStatus === 'sold') {
                $this->applyDelta($newPerformanceId, $today, 1, $newPrice, 0);
            }
        }

        // If sold and price changed, adjust revenue
        if ($newStatus === 'sold' && $newPrice !== $oldPrice) {
            $this->applyDelta($newPerformanceId, $today, 0, $newPrice - $oldPrice, 0);
        }

        // checked-in transitions
        if (empty($oldCheckedIn) && !empty($newCheckedIn)) {
            $this->applyDelta($newPerformanceId, $today, 0, 0, 1);
        } elseif (!empty($oldCheckedIn) && empty($newCheckedIn)) {
            $this->applyDelta($newPerformanceId, $today, 0, 0, -1);
        }
    }

    private function applyDelta(int $performanceId, Carbon $date, int $soldDelta, float $revenueDelta, int $checkedInDelta): void
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
