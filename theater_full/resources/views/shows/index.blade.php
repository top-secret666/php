@extends('layouts.app')

@section('title', 'Афиша')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Афиша спектаклей</h2>
        <a href="{{ route('shows.create') }}" class="btn btn-outline-light">Добавить спектакль</a>
    </div>

    <form method="GET" action="{{ route('shows.search') }}" class="row g-2 align-items-end mb-4">
        <div class="col-12 col-md-5">
            <label class="form-label text-muted small mb-1">Поиск</label>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                class="form-control"
                placeholder="Название / описание / режиссёр"
            />
        </div>

        <div class="col-12 col-md-3">
            <label class="form-label text-muted small mb-1">Режиссёр</label>
            <select name="director" class="form-select">
                <option value="">Все</option>
                @foreach(($directors ?? collect()) as $d)
                    <option value="{{ $d }}" @selected(request('director') === $d)>{{ $d }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-2">
            <label class="form-label text-muted small mb-1">Сортировка</label>
            <select name="sort" class="form-select">
                <option value="title" @selected(request('sort', 'title') === 'title')>Название</option>
                <option value="duration_minutes" @selected(request('sort') === 'duration_minutes')>Длительность</option>
                <option value="created_at" @selected(request('sort') === 'created_at')>Создано</option>
            </select>
        </div>

        <div class="col-6 col-md-1">
            <label class="form-label text-muted small mb-1">Напр.</label>
            <select name="dir" class="form-select">
                <option value="asc" @selected(request('dir', 'asc') === 'asc')>↑</option>
                <option value="desc" @selected(request('dir') === 'desc')>↓</option>
            </select>
        </div>

        <div class="col-12 col-md-1 d-grid">
            <button class="btn btn-primary" type="submit">OK</button>
        </div>

        <div class="col-12">
            <a class="link-light small" href="{{ route('shows.index') }}">Сбросить фильтры</a>
        </div>
    </form>

    <div class="row g-3">
        @foreach($shows as $show)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('shows.show', $show) }}" class="card-link">
                    <div class="card show-card h-100 text-white">
                        <img src="{{ $show->poster_url ?? '/images/poster-placeholder.jpg' }}" class="card-img-top poster" alt="{{ $show->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $show->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($show->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="badge badge-accent">{{ $show->duration_minutes }} мин</span>
                                <small class="text-muted">{{ $show->venue->name ?? '—' }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $shows->links() }}</div>
@endsection
