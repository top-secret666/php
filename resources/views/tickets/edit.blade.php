@extends('layouts.app')

@section('title', 'Редактировать билет')

@section('content')
    <h2>Редактировать билет</h2>
    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select name="status" id="status" class="form-select">
                <option value="reserved" {{ $ticket->status=='reserved' ? 'selected' : '' }}>Зарезервирован</option>
                <option value="sold" {{ $ticket->status=='sold' ? 'selected' : '' }}>Продан</option>
                <option value="cancelled" {{ $ticket->status=='cancelled' ? 'selected' : '' }}>Отменён</option>
            </select>
        </div>

        <button class="btn badge-accent text-white" type="submit">Сохранить</button>
    </form>
@endsection
