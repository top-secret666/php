@extends('layouts.app')

@section('title', 'Добавить показ')

@section('content')
    <h2>Добавить показ</h2>
    <form method="POST" action="{{ route('performances.store') }}">
        @csrf

        <div class="mb-3">
            <label for="show_id" class="form-label">Спектакль</label>
            <select name="show_id" id="show_id" class="form-select @error('show_id') is-invalid @enderror">
                <option value="">-- выбрать --</option>
                @foreach(App\Models\Show::all() as $show)
                    <option value="{{ $show->id }}" {{ old('show_id') == $show->id ? 'selected' : '' }}>{{ $show->title }}</option>
                @endforeach
            </select>
            @error('show_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="starts_at" class="form-label">Дата и время начала</label>
                <input type="datetime-local" class="form-control @error('starts_at') is-invalid @enderror" id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                @error('starts_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="ends_at" class="form-label">Дата и время окончания</label>
                <input type="datetime-local" class="form-control @error('ends_at') is-invalid @enderror" id="ends_at" name="ends_at" value="{{ old('ends_at') }}">
                @error('ends_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select">
                <option value="scheduled">Запланирован</option>
                <option value="cancelled">Отменён</option>
                <option value="completed">Завершён</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Примечания</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
    </form>
@endsection
