@extends('layouts.app')

@section('title', 'Актёры')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Актёры</h2>
        @auth
            <a href="{{ route('actors.create') }}" class="btn btn-outline-light">Добавить актёра</a>
        @endauth
    </div>

    <form method="GET" action="{{ route('actors.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-12 col-md-6">
            <label class="form-label text-muted small mb-1">Поиск по ФИО</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Иванов Иван" />
        </div>

        <div class="col-12 col-md-4">
            <label class="form-label text-muted small mb-1">Спектакль</label>
            <select name="show_id" class="form-select">
                <option value="">Все</option>
                @foreach($shows as $show)
                    <option value="{{ $show->id }}" @selected((string)request('show_id') === (string)$show->id)>
                        {{ $show->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-primary" type="submit">Фильтр</button>
        </div>

        <div class="col-12">
            <a class="link-light small" href="{{ route('actors.index') }}">Сбросить</a>
        </div>
    </form>

    <div class="list-group">
        @foreach($actors as $actor)
            <a href="{{ route('actors.show', $actor) }}" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between">
                    <strong>{{ $actor->full_name }}</strong>
                    <span class="text-muted small">
                        {{ optional($actor->shows->first())->title ?? '—' }}
                    </span>
                </div>
                @php($pivot = $actor->shows->first()?->pivot)
                @if($pivot?->character_name)
                    <div class="text-muted small">Роль: {{ $pivot->character_name }}</div>
                @endif
            </a>
        @endforeach
    </div>

    <div class="mt-4">{{ $actors->links() }}</div>
@endsection
