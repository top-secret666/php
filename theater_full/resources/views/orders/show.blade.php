@extends('layouts.app')

@section('content')
    <h1>Order #{{ $order->id }}</h1>
    <p>Status: {{ $order->status ?? 'pending' }}</p>
    <p>Total: {{ $order->total_amount }}</p>
@endsection
