@extends('layouts.app')

@section('title', 'Расписание')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Показы</h2>
        @if(auth()->check() && auth()->user()->is_admin)
            <a href="{{ route('performances.create') }}" class="btn btn-outline-light">Добавить показ</a>
        @endif
    </div>

    <div class="list-group">
        @foreach($performances as $performance)
            <a href="{{ route('performances.show', $performance) }}" class="list-group-item list-group-item-action bg-transparent text-white">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $performance->show->title ?? '—' }}</h5>
                    <small class="text-muted">{{ $performance->starts_at->format('d.m.Y H:i') }}</small>
                </div>
                <p class="mb-1 text-muted">{{ \Illuminate\Support\Str::limit((string) $performance->notes, 120) }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-4">{{ $performances->links() }}</div>
@endsection
