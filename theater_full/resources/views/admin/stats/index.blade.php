@extends('layouts.app')

@section('title', 'Статистика посещаемости')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4">Статистика посещаемости</h2>
        <a class="btn btn-outline-light" href="{{ route('shows.index') }}">На сайт</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <div class="text-muted small">Продано билетов</div>
                    <div class="h4 mb-0">{{ (int)($totals->tickets_sold_sum ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <div class="text-muted small">Проверено на входе</div>
                    <div class="h4 mb-0">{{ (int)($totals->checked_in_sum ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <div class="text-muted small">Выручка</div>
                    <div class="h4 mb-0">{{ number_format((float)($totals->revenue_sum ?? 0), 2, '.', ' ') }}</div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.stats.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-12 col-md-4">
            <label class="form-label text-muted small mb-1">Спектакль</label>
            <select name="show_id" class="form-select">
                <option value="">Все</option>
                @foreach($shows as $show)
                    <option value="{{ $show->id }}" @selected((string)request('show_id') === (string)$show->id)>{{ $show->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label text-muted small mb-1">С</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control" />
        </div>
        <div class="col-6 col-md-3">
            <label class="form-label text-muted small mb-1">По</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control" />
        </div>
        <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-accent" type="submit">Применить</button>
        </div>
        <div class="col-12">
            <a class="link-light small" href="{{ route('admin.stats.index') }}">Сбросить</a>
        </div>
    </form>

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
