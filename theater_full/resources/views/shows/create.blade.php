@extends('layouts.app')

@section('title', 'Добавить спектакль')

@section('content')
    <h2>Добавить спектакль</h2>
    <form method="POST" action="{{ route('shows.store') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="director" class="form-label">Режиссёр</label>
            <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ old('director') }}">
            @error('director') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="duration_minutes" class="form-label">Длительность (мин)</label>
                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes') }}">
                @error('duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="language" class="form-label">Язык</label>
                <input type="text" class="form-control" id="language" name="language" value="{{ old('language') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="venue_id" class="form-label">Зал</label>
                <select name="venue_id" id="venue_id" class="form-select @error('venue_id') is-invalid @enderror">
                    <option value="">-- выбрать --</option>
                    @foreach(App\Models\Venue::all() as $venue)
                        <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                    @endforeach
                </select>
                @error('venue_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
    </form>
@endsection
