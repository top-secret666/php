<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Http\Requests\StoreShowRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShowController extends Controller
{
    public function __construct()
    {
        // allow guests to view index/show/search
        // require auth+admin for creating/updating/deleting
        $this->middleware('auth')->except(['index', 'show', 'search']);
        $this->middleware('admin')->except(['index', 'show', 'search']);
        // Note: policy registration may not be available in this lightweight bootstrap.
        // Skipping authorizeResource to avoid accidental 403 for guests on index/show.
    }
    public function index(Request $request)
    {
        [$shows, $directors] = $this->getFilteredShows($request);
        return view('shows.index', compact('shows', 'directors'));
    }

    public function create()
    {
        return view('shows.create');
    }

    public function store(StoreShowRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster_url'] = Storage::url($path);
        }

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

    public function update(StoreShowRequest $request, Show $show)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster_url'] = Storage::url($path);
        }

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
        // Keep /shows/search for UI, but share the same logic as the index.
        return $this->index($request);
    }

    /**
     * @return array{0:\Illuminate\Contracts\Pagination\LengthAwarePaginator, 1:\Illuminate\Support\Collection<int, string>}
     */
    protected function getFilteredShows(Request $request): array
    {
        $q = trim((string) $request->get('q', ''));
        $director = trim((string) $request->get('director', ''));

        $sort = (string) $request->get('sort', 'title');
        $dir = strtolower((string) $request->get('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $allowedSorts = ['title', 'duration_minutes', 'created_at'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'title';
        }

        $query = Show::query()->with('venue');

        if ($q !== '') {
            $query->where(function (Builder $inner) use ($q) {
                $inner
                    ->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('director', 'like', "%{$q}%");
            });
        }

        if ($director !== '') {
            $query->where('director', $director);
        }

        $shows = $query
            ->orderBy($sort, $dir)
            ->paginate(15)
            ->appends($request->query());

        // Collections usage (requirement): build filter options as a Collection.
        $directors = Show::query()
            ->select('director')
            ->whereNotNull('director')
            ->where('director', '!=', '')
            ->distinct()
            ->orderBy('director')
            ->pluck('director')
            ->values();

        return [$shows, $directors];
    }
}
