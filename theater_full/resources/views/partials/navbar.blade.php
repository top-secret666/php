<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Театр</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('shows.index') }}">Спектакли</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('actors.index') }}">Актёры</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('performances.index') }}">Показы</a></li>
                @auth
                    @if(Auth::user()->is_admin)
                        <li class="nav-item"><a class="nav-link" href="{{ route('tickets.index') }}">Билеты</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Заказы</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Корзина</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Мои заказы</a></li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                        <li class="nav-item"><a class="btn btn-outline-light me-2" href="{{ route('login') }}">Войти</a></li>
                        <li class="nav-item"><a class="btn btn-accent" href="{{ route('register') }}">Регистрация</a></li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            @if(Auth::user()->is_admin)
                                <li><a class="dropdown-item" href="{{ route('admin.stats.index') }}">Статистика</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li><a class="dropdown-item" href="#">Профиль</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <button class="dropdown-item" type="submit">Выйти</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
