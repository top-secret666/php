<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use Illuminate\Http\Request;
use App\Http\Requests\StorePerformanceRequest;

class PerformanceController extends Controller
{
    public function __construct()
    {
        // allow everyone to browse schedule
        // require auth+admin for creating/updating/deleting
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $performances = Performance::with('show')->paginate(20);
        return view('performances.index', compact('performances'));
    }

    public function create()
    {
        return view('performances.create');
    }

    public function store(StorePerformanceRequest $request)
    {
        $performance = Performance::create($request->validated());
        return redirect()->route('performances.show', $performance);
    }

    public function show(Performance $performance)
    {
        return view('performances.show', compact('performance'));
    }

    public function edit(Performance $performance)
    {
        return view('performances.edit', compact('performance'));
    }

    public function update(StorePerformanceRequest $request, Performance $performance)
    {
        $performance->update($request->validated());
        return redirect()->route('performances.show', $performance);
    }

    public function destroy(Performance $performance)
    {
        $performance->delete();
        return redirect()->route('performances.index');
    }
}
