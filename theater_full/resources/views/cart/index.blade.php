@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Корзина</h2>
        <a class="btn btn-outline-light" href="{{ route('shows.index') }}">Продолжить выбор</a>
    </div>

    <div class="card bg-dark text-light">
        <div class="card-body">
            <div class="text-muted mb-3">
                Здесь показываются ваши <strong>зарезервированные</strong> билеты (ещё не привязанные к заказу).
            </div>

            @if($tickets->isEmpty())
                <p class="text-muted mb-0">Корзина пуста.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle">
                        <thead>
                        <tr>
                            <th>Спектакль</th>
                            <th>Показ</th>
                            <th>Место</th>
                            <th class="text-end">Цена</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->performance?->show?->title ?? '—' }}</td>
                                <td class="text-muted small">{{ optional($ticket->performance?->starts_at)->format('d.m.Y H:i') ?? '—' }}</td>
                                <td>{{ $ticket->seat?->label ?? '—' }}</td>
                                <td class="text-end">{{ number_format((float)($ticket->price ?? 0), 2, '.', ' ') }}</td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-light" href="{{ route('tickets.show', $ticket) }}">Открыть</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">Итого:</div>
                    <div class="h5 mb-0">{{ number_format((float)$total, 2, '.', ' ') }}</div>
                </div>

                <form method="POST" action="{{ route('cart.checkout') }}" class="mt-3">
                    @csrf
                    <button class="btn btn-accent" type="submit">Оформить заказ</button>
                </form>
            @endif
        </div>
    </div>
@endsection
