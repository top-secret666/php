@extends('layouts.app')

@section('title', $actor->full_name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">{{ $actor->full_name }}</h2>
        @auth
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="{{ route('actors.edit', $actor) }}">Редактировать</a>
                <form method="POST" action="{{ route('actors.destroy', $actor) }}" onsubmit="return confirm('Удалить актёра?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            </div>
        @endauth
    </div>

    @if($actor->birth_date)
        <p class="text-muted">Дата рождения: {{ $actor->birth_date->format('d.m.Y') }}</p>
    @endif

    @if($actor->bio)
        <div class="mb-4">
            <h5>Биография</h5>
            <p class="text-muted">{{ $actor->bio }}</p>
        </div>
    @endif

    <div class="mb-4">
        <h5>Спектакли и роли</h5>
        @if($actor->shows->isEmpty())
            <p class="text-muted">Нет привязанных спектаклей.</p>
        @else
            <ul class="list-group">
                @foreach($actor->shows as $show)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <a href="{{ route('shows.show', $show) }}">{{ $show->title }}</a>
                            @if($show->pivot?->character_name)
                                <span class="text-muted">— {{ $show->pivot->character_name }}</span>
                            @endif
                        </span>
                        <span class="text-muted small">реж.: {{ $show->director ?? '—' }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <a class="btn btn-outline-light" href="{{ route('actors.index') }}">Назад</a>
@endsection
