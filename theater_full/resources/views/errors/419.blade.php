@extends('layouts.app')

@section('title', 'Сессия истекла')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h1 class="h3 mb-2">419 — Page Expired</h1>
                    <p class="text-muted mb-3">
                        Обычно это значит, что истёк CSRF-токен (например, страница была открыта давно) или браузер не сохранил cookie сессии.
                    </p>

                    <ul class="text-muted">
                        <li>Обновите страницу и попробуйте отправить форму ещё раз.</li>
                        <li>Используйте один и тот же адрес: <strong>{{ config('app.url') }}</strong> (не смешивайте <code>localhost</code> и <code>127.0.0.1</code>).</li>
                        <li>Если открыто несколько вкладок — попробуйте закрыть лишние.</li>
                    </ul>

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-light">Назад</a>
                        <a href="{{ route('shows.index') }}" class="btn btn-accent">На главную</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection