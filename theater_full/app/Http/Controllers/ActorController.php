<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActorRequest;
use App\Models\Actor;
use App\Models\Show;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function __construct()
    {
        // allow guests to view index/show, require auth for creating/updating/deleting
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $showId = $request->get('show_id');

        $actors = Actor::query()
            ->with(['shows'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where('full_name', 'like', "%{$q}%");
            })
            ->when($showId, function ($query) use ($showId) {
                $query->whereHas('shows', function ($inner) use ($showId) {
                    $inner->where('shows.id', $showId);
                });
            })
            ->orderBy('full_name')
            ->paginate(20)
            ->appends($request->query());

        $shows = Show::query()->orderBy('title')->get();

        return view('actors.index', compact('actors', 'shows'));
    }

    public function create()
    {
        $shows = Show::query()->orderBy('title')->get();
        return view('actors.create', compact('shows'));
    }

    public function store(StoreActorRequest $request)
    {
        $data = $request->validated();

        $actor = Actor::create([
            'full_name' => $data['full_name'],
            'bio' => $data['bio'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);

        if (!empty($data['show_id'])) {
            $actor->shows()->sync([
                (int) $data['show_id'] => [
                    'character_name' => $data['character_name'] ?? null,
                    'billing_order' => $data['billing_order'] ?? null,
                ]
            ]);
        }

        return redirect()->route('actors.show', $actor);
    }

    public function show(Actor $actor)
    {
        $actor->load(['shows']);
        return view('actors.show', compact('actor'));
    }

    public function edit(Actor $actor)
    {
        $actor->load(['shows']);
        $shows = Show::query()->orderBy('title')->get();

        // For the assignment we treat "роль+спектакль" as one main entry in the form.
        $currentShow = $actor->shows->first();
        $pivot = $currentShow?->pivot;

        return view('actors.edit', compact('actor', 'shows', 'currentShow', 'pivot'));
    }

    public function update(StoreActorRequest $request, Actor $actor)
    {
        $data = $request->validated();

        $actor->update([
            'full_name' => $data['full_name'],
            'bio' => $data['bio'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
        ]);

        if (!empty($data['show_id'])) {
            $actor->shows()->sync([
                (int) $data['show_id'] => [
                    'character_name' => $data['character_name'] ?? null,
                    'billing_order' => $data['billing_order'] ?? null,
                ]
            ]);
        } else {
            $actor->shows()->detach();
        }

        return redirect()->route('actors.show', $actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return redirect()->route('actors.index');
    }
}
