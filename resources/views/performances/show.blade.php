@extends('layouts.app')

@section('title', $performance->show->title . ' — ' . $performance->starts_at->format('d.m.Y H:i'))

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $performance->show->title ?? '—' }}</h1>
            <p class="text-muted">{{ $performance->starts_at->format('d.m.Y H:i') }} — {{ $performance->ends_at?->format('H:i') ?? '' }}</p>
            <p>{{ $performance->notes }}</p>

            <h5 class="mt-4">Купить билет</h5>
            <a href="{{ route('tickets.create') }}?performance_id={{ $performance->id }}" class="btn badge-accent text-white">Купить</a>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <p>Статус: <strong>{{ ucfirst($performance->status) }}</strong></p>
                    <p>Продано: {{ $performance->stats->sold_tickets ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
