@extends('layouts.app')

@section('title', $performance->show->title . ' — ' . $performance->starts_at->format('d.m.Y H:i'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">{{ $performance->show->title ?? '—' }}</h1>
            <div class="text-muted">{{ $performance->starts_at->format('d.m.Y H:i') }}@if($performance->ends_at) — {{ $performance->ends_at->format('H:i') }}@endif</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-light" href="{{ route('performances.index') }}">Назад</a>
            @if(auth()->check() && auth()->user()->is_admin)
                <a class="btn btn-outline-light" href="{{ route('performances.edit', $performance) }}">Редактировать</a>
                <form method="POST" action="{{ route('performances.destroy', $performance) }}" onsubmit="return confirm('Удалить показ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-8">
            @if(!empty($performance->notes))
                <div class="card bg-dark text-light">
                    <div class="card-body">
                        <h5 class="card-title">Примечания</h5>
                        <div class="text-muted">{!! nl2br(e($performance->notes)) !!}</div>
                    </div>
                </div>
            @endif

            <div class="mt-3">
                <h5 class="mt-4">Купить билет</h5>
                <a href="{{ route('tickets.create') }}?performance_id={{ $performance->id }}" class="btn badge-accent text-white">Купить</a>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <p class="mb-2">Статус: <strong>{{ ucfirst($performance->status) }}</strong></p>
                    <p class="mb-0 text-muted small">Статистика по посещаемости доступна в админ-разделе.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
