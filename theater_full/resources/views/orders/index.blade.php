@extends('layouts.app')

@section('title', 'Заказы')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Заказы</h2>
        @auth
            <a href="{{ route('orders.create') }}" class="btn btn-outline-light">Создать заказ</a>
        @endauth
    </div>

    <div class="list-group">
        @forelse ($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="list-group-item list-group-item-action">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Заказ #{{ $order->id }}</strong>
                        <div class="text-muted small">
                            Пользователь: {{ $order->user->name ?? ('#' . ($order->user_id ?? '—')) }}
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-muted small">{{ optional($order->created_at)->format('d.m.Y H:i') }}</div>
                        <div>
                            <span class="badge bg-secondary">{{ $order->status ?? 'pending' }}</span>
                            <span class="badge badge-accent">{{ number_format((float)($order->total_amount ?? 0), 2) }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="list-group-item text-muted">Заказов пока нет.</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
