@extends('layouts.app')

@section('title', 'Билет #' . $ticket->id)

@section('content')
    <div class="card bg-dark text-light">
        <div class="card-body">
            <h3>Билет #{{ $ticket->id }}</h3>
            <p>{{ $ticket->performance->show->title ?? '' }} — {{ $ticket->performance->starts_at->format('d.m.Y H:i') }}</p>
            <p>Место: {{ $ticket->seat->label ?? '' }}</p>
            <p>Цена: {{ number_format(($ticket->price_tier->amount_cents ?? 0)/100, 2) }} {{ $ticket->price_tier->currency ?? 'USD' }}</p>
            <p>Статус: <strong>{{ $ticket->status }}</strong></p>
            <div class="mt-3">
                <a href="#" class="btn badge-accent text-white">Скачать билет (PDF)</a>
            </div>
        </div>
    </div>
@endsection
