@extends('layouts.app')

@section('title', 'Войти')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h3 class="mb-1">Вход</h3>
                    <div class="text-muted mb-3">Добро пожаловать обратно.</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"> 
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>

                        <button type="submit" class="btn btn-accent">Войти</button>
                        <a class="btn btn-link text-white ms-2" href="{{ route('password.request') }}">Забыли пароль?</a>

                        <div class="text-muted small mt-3">
                            Нет аккаунта? <a href="{{ route('register') }}" class="text-white">Зарегистрируйтесь</a>.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
