@extends('layouts.app')

@section('title', 'Билет #' . $ticket->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Билет #{{ $ticket->id }}</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-light" href="{{ route('tickets.index') }}">Назад</a>
            @auth
                <a class="btn btn-outline-light" href="{{ route('tickets.edit', $ticket) }}">Редактировать</a>
                <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Удалить билет?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            @endauth
        </div>
    </div>

    <div class="card bg-dark text-light">
        <div class="card-body">
            <p class="mb-2">
                {{ $ticket->performance->show->title ?? '—' }}
                @if($ticket->performance?->starts_at)
                    — {{ $ticket->performance->starts_at->format('d.m.Y H:i') }}
                @endif
            </p>
            <p class="mb-2">Место: {{ $ticket->seat->label ?? '—' }}</p>
            <p class="mb-2">Цена: {{ number_format(($ticket->price_tier->amount_cents ?? 0)/100, 2) }} {{ $ticket->price_tier->currency ?? 'USD' }}</p>
            <p class="mb-0">Статус: <strong>{{ $ticket->status }}</strong></p>

            <div class="mt-3">
                <span class="text-muted small">PDF/QR-генерация — можно добавить позже (сейчас не требуется заданием).</span>
            </div>
        </div>
    </div>
@endsection
