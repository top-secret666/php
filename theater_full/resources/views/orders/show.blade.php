@extends('layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Заказ #{{ $order->id }}</h1>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-light" href="{{ route('orders.index') }}">Назад</a>
            @auth
                <a class="btn btn-outline-light" href="{{ route('orders.edit', $order) }}">Редактировать</a>
                <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Удалить заказ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">Удалить</button>
                </form>
            @endauth
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <p class="mb-2">Статус: <strong>{{ $order->status ?? 'pending' }}</strong></p>
                    <p class="mb-2">Сумма: <strong>{{ number_format((float)($order->total_amount ?? 0), 2) }}</strong></p>
                    <p class="mb-0 text-muted">Пользователь: {{ $order->user->name ?? ('#' . ($order->user_id ?? '—')) }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h5 class="card-title">Билеты в заказе</h5>
                    @php($tickets = $order->tickets ?? collect())
                    @if($tickets->isEmpty())
                        <p class="text-muted mb-0">Билетов в заказе нет.</p>
                    @else
                        <ul class="list-group">
                            @foreach($tickets as $ticket)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        <a href="{{ route('tickets.show', $ticket) }}">Билет #{{ $ticket->id }}</a>
                                        <span class="text-muted small">({{ $ticket->status }})</span>
                                    </span>
                                    <span class="text-muted small">{{ $ticket->seat->label ?? '—' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
