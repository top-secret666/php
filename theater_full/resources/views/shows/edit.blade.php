@extends('layouts.app')

@section('title', 'Редактировать спектакль')

@section('content')
    <h2>Редактировать спектакль</h2>
    <form method="POST" action="{{ route('shows.update', $show) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Название</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $show->title) }}">
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Описание</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $show->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="duration_minutes" class="form-label">Длительность (мин)</label>
                <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', $show->duration_minutes) }}">
                @error('duration_minutes') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label for="language" class="form-label">Язык</label>
                <input type="text" class="form-control" id="language" name="language" value="{{ old('language', $show->language) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label for="venue_id" class="form-label">Зал</label>
                <select name="venue_id" id="venue_id" class="form-select @error('venue_id') is-invalid @enderror">
                    <option value="">-- выбрать --</option>
                    @foreach(App\Models\Venue::all() as $venue)
                        <option value="{{ $venue->id }}" {{ old('venue_id', $show->venue_id) == $venue->id ? 'selected' : '' }}>{{ $venue->name }}</option>
                    @endforeach
                </select>
                @error('venue_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
    </form>
@endsection
