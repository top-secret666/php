<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceStat;
use App\Models\Show;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $showId = $request->get('show_id');
        $from = $request->get('date_from');
        $to = $request->get('date_to');

        $base = PerformanceStat::query()
            ->when($showId, function ($q) use ($showId) {
                $q->whereHas('performance', function ($p) use ($showId) {
                    $p->where('show_id', $showId);
                });
            })
            ->when($from, fn($q) => $q->whereDate('date_calculated', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('date_calculated', '<=', $to));

        $totals = (clone $base)
            ->selectRaw('COALESCE(SUM(tickets_sold),0) as tickets_sold_sum')
            ->selectRaw('COALESCE(SUM(checked_in_count),0) as checked_in_sum')
            ->selectRaw('COALESCE(SUM(revenue),0) as revenue_sum')
            ->first();

        $stats = $base
            ->with(['performance.show'])
            ->orderByDesc('date_calculated')
            ->orderByDesc('id')
            ->paginate(30)
            ->appends($request->query());

        $shows = Show::query()->orderBy('title')->get(['id', 'title']);

        return view('admin.stats.index', compact('stats', 'shows', 'totals'));
    }
}
