<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    public function __construct()
    {
        // allow guests to view index/show/search, require auth for creating/updating/deleting
        $this->middleware('auth')->except(['index', 'show', 'search']);
        // Note: policy registration may not be available in this lightweight bootstrap.
        // Skipping authorizeResource to avoid accidental 403 for guests on index/show.
    }
    public function index(Request $request)
    {
        $shows = Show::with('venue')->paginate(15);
        return view('shows.index', compact('shows'));
    }

    public function create()
    {
        return view('shows.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:10',
            'age_rating' => 'nullable|string|max:10',
            'venue_id' => 'nullable|integer|exists:venues,id',
        ]);

        $show = Show::create($data);
        return redirect()->route('shows.show', $show);
    }

    public function show(Show $show)
    {
        return view('shows.show', compact('show'));
    }

    public function edit(Show $show)
    {
        return view('shows.edit', compact('show'));
    }

    public function update(Request $request, Show $show)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:10',
            'age_rating' => 'nullable|string|max:10',
            'venue_id' => 'nullable|integer|exists:venues,id',
        ]);

        $show->update($data);
        return redirect()->route('shows.show', $show);
    }

    public function destroy(Show $show)
    {
        $show->delete();
        return redirect()->route('shows.index');
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $shows = Show::where('title', 'ilike', "%{$q}%")->paginate(15);
        return view('shows.index', compact('shows'));
    }
}
