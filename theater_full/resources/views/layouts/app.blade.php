<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Театр')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
            --bg: #0b0f14;
            --surface: #0f1720;
            --surface-2: #111b26;
            --text: #e6eef6;
            --muted: rgba(230,238,246,0.68);
            --border: rgba(255,255,255,0.10);
            --accent: #e50914;
            --accent-2: #ff3b30;
        }

        body { background-color: var(--bg); color: var(--text); font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
        a { color: inherit; }
        a:hover { color: #fff; }

        .navbar {
            backdrop-filter: saturate(140%) blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .navbar-dark .navbar-brand { font-weight: 800; letter-spacing: 0.5px; }
        .nav-link { color: rgba(255,255,255,0.85) !important; }
        .nav-link:hover { color: #fff !important; }

        .btn-accent{
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            font-weight: 700;
        }
        .btn-accent:hover{ background: var(--accent-2); border-color: var(--accent-2); color: #fff; }
        .badge-accent { background: var(--accent); }

        .hero {
            background: linear-gradient(180deg, rgba(0,0,0,0.55), rgba(11,15,20,0.96)), url('/images/theater-hero.svg') center/cover no-repeat;
            padding: 4.5rem 0 3.5rem;
            color: #fff;
        }
        .hero h1{ letter-spacing: -0.02em; }
        .hero .lead{ color: rgba(255,255,255,0.82); }

        .show-card {
            background: var(--surface);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 16px;
            overflow: hidden;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }
        .show-card:hover{
            transform: translateY(-4px);
            border-color: rgba(255,255,255,0.14);
            box-shadow: 0 18px 48px rgba(0,0,0,0.45);
        }
        .poster { height: 270px; object-fit: cover; }
        a.card-link { text-decoration: none; }

        .card { border-color: rgba(255,255,255,0.08); border-radius: 16px; }
        .card.bg-dark { background-color: var(--surface) !important; }
        .text-muted { color: var(--muted) !important; }
        .form-control, .form-select {
            background-color: var(--surface);
            border-color: rgba(255,255,255,0.12);
            color: var(--text);
            border-radius: 12px;
        }
        .form-control::placeholder{ color: rgba(230,238,246,0.45); }
        .form-control:focus, .form-select:focus {
            background-color: var(--surface);
            color: var(--text);
            border-color: rgba(229,9,20,0.65);
            box-shadow: 0 0 0 0.2rem rgba(229,9,20,0.18);
        }
        .list-group-item {
            background-color: var(--surface);
            border-color: rgba(255,255,255,0.08);
            color: var(--text);
        }
        .list-group-item-action:hover {
            background-color: rgba(255,255,255,0.06);
            color: #fff;
        }

        .page-wrap{ min-height: calc(100vh - 56px); }
        .container-narrow{ max-width: 980px; }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    @if(request()->routeIs('shows.index'))
        <section class="hero">
            <div class="container">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-lg-7">
                        <h1 class="display-5 fw-bold">Театр онлайн</h1>
                        <p class="lead">Афиша, расписание показов и билеты — в одном месте.</p>
                        <form method="GET" action="{{ route('shows.search') }}" class="mt-3">
                            <div class="input-group">
                                <input name="q" value="{{ request('q') }}" class="form-control" type="search" placeholder="Найти спектакль по названию, описанию или режиссёру" aria-label="Search">
                                <button class="btn btn-accent" type="submit">Искать</button>
                            </div>
                        </form>
                        <div class="text-muted small mt-2">Подсказка: попробуйте “комедия”, “Шекспир”, “Иванов”.</div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="card bg-dark text-light">
                            <div class="card-body">
                                <div class="fw-semibold">Быстрый старт</div>
                                <div class="text-muted small mt-1">Создайте спектакль и добавьте показы, чтобы начать продавать билеты.</div>
                                <div class="d-flex gap-2 mt-3">
                                    @auth
                                        <a href="{{ route('shows.create') }}" class="btn btn-accent">Добавить спектакль</a>
                                    @endauth
                                    <a href="{{ route('performances.index') }}" class="btn btn-outline-light">Открыть расписание</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <main class="container my-5 page-wrap">
        <x-alerts />
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
