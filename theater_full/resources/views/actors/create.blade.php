@extends('layouts.app')

@section('title', 'Добавить актёра')

@section('content')
    <h2>Добавить актёра</h2>

    <form method="POST" action="{{ route('actors.store') }}">
        @csrf

        <div class="mb-3">
            <label for="full_name" class="form-label">ФИО</label>
            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}">
            @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="bio" class="form-label">Биография</label>
            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
            @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Дата рождения</label>
            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
            @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr class="my-4" />
        <h5 class="mb-3">Привязка к спектаклю (роль)</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="show_id" class="form-label">Спектакль</label>
                <select name="show_id" id="show_id" class="form-select @error('show_id') is-invalid @enderror">
                    <option value="">— не выбрано —</option>
                    @foreach($shows as $show)
                        <option value="{{ $show->id }}" {{ old('show_id') == $show->id ? 'selected' : '' }}>{{ $show->title }}</option>
                    @endforeach
                </select>
                @error('show_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="character_name" class="form-label">Роль</label>
                <input type="text" class="form-control @error('character_name') is-invalid @enderror" id="character_name" name="character_name" value="{{ old('character_name') }}" placeholder="Например: Гамлет">
                @error('character_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
        <a class="btn btn-outline-light" href="{{ route('actors.index') }}">Отмена</a>
    </form>
@endsection
