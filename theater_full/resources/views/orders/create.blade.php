@extends('layouts.app')

@section('title', 'Создать заказ')

@section('content')
    <h2 class="h4 mb-3">Создать заказ</h2>

    <form method="POST" action="{{ route('orders.store') }}">
        @csrf

        @if(auth()->user()?->is_admin)
            <div class="mb-3">
                <label for="user_id" class="form-label">Пользователь</label>
                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
                    <option value="">-- выбрать --</option>
                    @foreach(\App\Models\User::query()->orderBy('name')->get() as $user)
                        <option value="{{ $user->id }}" {{ (string)old('user_id') === (string)$user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="text-muted small mb-3">Заказ будет оформлен на вас.</div>
        @endif

        <div class="mb-3">
            <label for="total_amount" class="form-label">Сумма</label>
            <input
                type="number"
                step="0.01"
                min="0"
                class="form-control @error('total_amount') is-invalid @enderror"
                id="total_amount"
                name="total_amount"
                value="{{ old('total_amount', '0.00') }}"
            >
            @error('total_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <input type="text" class="form-control @error('status') is-invalid @enderror" id="status" name="status" value="{{ old('status', 'pending') }}">
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            <div class="form-text">Например: pending / paid / cancelled</div>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
        <a class="btn btn-outline-light" href="{{ route('orders.index') }}">Отмена</a>
    </form>
@endsection
