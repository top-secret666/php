<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShowRequest;

class ShowController extends Controller
{
    public function index(Request $request)
    {
        $shows = Show::with('venue')->paginate(15);
        return view('shows.index', compact('shows'));
    }

    public function create()
    {
        return view('shows.create');
    }

    public function store(StoreShowRequest $request)
    {
        $show = Show::create($request->validated());
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

    public function update(StoreShowRequest $request, Show $show)
    {
        $show->update($request->validated());
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
