<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Театр')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0f14; color: #e6eef6; }
        .navbar-dark .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .hero {
            background: linear-gradient(180deg, rgba(0,0,0,0.55), rgba(0,0,0,0.7)), url('/images/theater-hero.jpg') center/cover no-repeat;
            padding: 4rem 0;
            color: #fff;
        }
        .show-card { background: #0f1720; border: none; }
        .show-card .card-title { color: #fff; }
        .badge-accent { background: #e50914; }
        .search-input { max-width: 600px; }
        .poster { height: 260px; object-fit: cover; }
        a.card-link { text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <section class="hero">
        <div class="container">
            <h1 class="display-5 fw-bold">Театр Онлайн</h1>
            <p class="lead">Афиша спектаклей и продажа билетов — быстро и красиво.</p>
            <form method="GET" action="{{ route('shows.search') }}" class="d-flex mt-3">
                <input name="q" class="form-control me-2 search-input" type="search" placeholder="Поиск спектаклей" aria-label="Search">
                <button class="btn badge-accent text-white" type="submit">Поиск</button>
            </form>
        </div>
    </section>

    <main class="container my-5">
        @include('partials.messages')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
