@extends('layouts.app')

@section('title', 'Купить билет')

@section('content')
    <h2>Купить билет</h2>
    <form method="POST" action="{{ route('tickets.store') }}">
        @csrf
        <div class="mb-3">
            <label for="performance_id" class="form-label">Показ</label>
            <select name="performance_id" id="performance_id" class="form-select @error('performance_id') is-invalid @enderror">
                <option value="">-- выбрать --</option>
                @foreach(App\Models\Performance::with('show')->get() as $performance)
                    <option value="{{ $performance->id }}" {{ request('performance_id') == $performance->id ? 'selected' : '' }}>{{ $performance->show->title ?? '' }} — {{ $performance->starts_at->format('d.m.Y H:i') }}</option>
                @endforeach
            </select>
            @error('performance_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="seat_id" class="form-label">Место</label>
            <select name="seat_id" id="seat_id" class="form-select @error('seat_id') is-invalid @enderror">
                <option value="">-- выбрать --</option>
                @foreach(App\Models\Seat::all() as $seat)
                    <option value="{{ $seat->id }}">{{ $seat->label }}</option>
                @endforeach
            </select>
            @error('seat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="price_tier_id" class="form-label">Тариф</label>
            <select name="price_tier_id" id="price_tier_id" class="form-select @error('price_tier_id') is-invalid @enderror">
                <option value="">-- выбрать --</option>
                @foreach(App\Models\PriceTier::all() as $tier)
                    <option value="{{ $tier->id }}">{{ $tier->name }} — {{ number_format($tier->amount_cents/100,2) }} {{ $tier->currency }}</option>
                @endforeach
            </select>
            @error('price_tier_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button class="btn badge-accent text-white" type="submit">Купить</button>
    </form>
@endsection
