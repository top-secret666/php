@extends('layouts.app')

@section('title', $show->title)

@section('content')
    <div class="row">
        <div class="col-md-8">
            <img src="{{ $show->poster_url ?? '/images/poster-placeholder.jpg' }}" class="img-fluid rounded mb-3" alt="{{ $show->title }}">
            <h1>{{ $show->title }}</h1>
            <p class="text-muted">{{ $show->duration_minutes }} мин • {{ $show->language ?? '—' }}</p>
            @if($show->director)
                <p class="text-muted">Режиссёр: {{ $show->director }}</p>
            @endif
            <p>{{ $show->description }}</p>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title">Билеты</h5>
                    <p class="card-text">Смотреть расписание показов и купить билет.</p>
                    <a href="{{ route('performances.index') }}?show_id={{ $show->id }}" class="btn badge-accent text-white">Посмотреть показы</a>
                </div>
            </div>
        </div>
    </div>
@endsection
