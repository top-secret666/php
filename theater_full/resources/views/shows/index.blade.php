@extends('layouts.app')

@section('title', 'Афиша')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Афиша спектаклей</h2>
        <a href="{{ route('shows.create') }}" class="btn btn-outline-light">Добавить спектакль</a>
    </div>

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
