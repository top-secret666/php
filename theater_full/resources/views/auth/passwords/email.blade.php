@extends('layouts.app')

@section('title', 'Восстановление пароля')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h3 class="mb-3">Восстановление пароля</h3>
                    <p>Функция восстановления пароля пока не реализована.</p>
                    <a href="{{ route('login') }}" class="btn badge-accent text-white">Назад к входу</a>
                </div>
            </div>
        </div>
    </div>
@endsection
