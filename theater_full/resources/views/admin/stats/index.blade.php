@extends('layouts.app')

@section('title', 'Статистика посещаемости')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Статистика посещаемости</h2>
        <a class="btn btn-outline-light" href="{{ route('admin.dashboard') }}">Админ</a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
            <tr>
                <th>Дата расчёта</th>
                <th>Спектакль</th>
                <th>Показ</th>
                <th class="text-end">Продано</th>
                <th class="text-end">Проверено</th>
                <th class="text-end">Выручка</th>
            </tr>
            </thead>
            <tbody>
            @foreach($stats as $row)
                <tr>
                    <td>{{ optional($row->date_calculated)->format('d.m.Y') ?? '—' }}</td>
                    <td>{{ $row->performance?->show?->title ?? '—' }}</td>
                    <td class="text-muted small">{{ optional($row->performance?->starts_at)->format('d.m.Y H:i') ?? '—' }}</td>
                    <td class="text-end">{{ $row->tickets_sold }}</td>
                    <td class="text-end">{{ $row->checked_in_count }}</td>
                    <td class="text-end">{{ number_format((float) $row->revenue, 2, '.', ' ') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $stats->links() }}</div>
@endsection
