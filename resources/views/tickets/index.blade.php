@extends('layouts.app')

@section('title', 'Билеты')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Билеты</h2>
        <a href="{{ route('tickets.create') }}" class="btn btn-outline-light">Создать билет</a>
    </div>

    <div class="list-group">
        @foreach($tickets as $ticket)
            <a href="{{ route('tickets.show', $ticket) }}" class="list-group-item list-group-item-action bg-transparent text-white">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $ticket->performance->show->title ?? '—' }} — {{ $ticket->seat->label ?? '—' }}</h5>
                    <small class="text-muted">{{ $ticket->created_at->format('d.m.Y H:i') }}</small>
                </div>
                <p class="mb-1 text-muted">Статус: {{ $ticket->status }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-4">{{ $tickets->links() }}</div>
@endsection
