@extends('layouts.app')

@section('title', $show->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $show->title }}</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-light" href="{{ route('shows.index') }}">Назад</a>
            @if(auth()->check() && auth()->user()->is_admin)
                <a class="btn btn-outline-light" href="{{ route('shows.edit', $show) }}">Редактировать</a>
                <form method="POST" action="{{ route('shows.destroy', $show) }}" onsubmit="return confirm('Удалить спектакль?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-5">
            <img
                src="{{ $show->poster_url ?: asset('images/poster-placeholder.svg') }}"
                onerror="this.onerror=null;this.src='{{ asset('images/poster-placeholder.svg') }}';"
                class="img-fluid rounded"
                alt="{{ $show->title }}"
            >
        </div>
        <div class="col-12 col-lg-7">
            <p class="text-muted mb-2">{{ $show->duration_minutes }} мин • {{ $show->language ?? '—' }}</p>
            @if($show->director)
                <p class="text-muted mb-2">Режиссёр: {{ $show->director }}</p>
            @endif

            @if(!empty($show->description))
                <div class="mb-4">
                    <h5 class="mb-2">Описание</h5>
                    <div class="text-muted">{!! nl2br(e($show->description)) !!}</div>
                </div>
            @endif

            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title mb-2">Билеты и расписание</h5>
                    <p class="card-text text-muted">Смотреть ближайшие показы и купить билет.</p>
                    <a href="{{ route('performances.index') }}?show_id={{ $show->id }}" class="btn badge-accent text-white">Посмотреть показы</a>
                </div>
            </div>
        </div>
    </div>
@endsection
