<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerformanceStat;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $stats = PerformanceStat::query()
            ->with(['performance.show'])
            ->orderByDesc('date_calculated')
            ->orderByDesc('id')
            ->paginate(30);

        return view('admin.stats.index', compact('stats'));
    }
}
