# Работа с коллекциями Laravel — примеры

Ниже — примеры операций с коллекциями для предметной области театра.

Фильтрация показов по статусу:

```php
$upcoming = Performance::where('status', 'scheduled')->get();
$soonAndEvening = $upcoming->filter(function($p) {
    return $p->starts_at->hour >= 18; // вечерние показы
});
```

Группировка спектаклей по жанру:

```php
$showsByGenre = Show::with('genres')->get()->flatMap(function($show) {
    return $show->genres->map(fn($g) => [$g->name => $show]);
})->collapse()->groupBy(fn($show) => $show->genres->first()->name ?? 'Прочее');
```

Получение списка названий спектаклей и их длительности в минутках:

```php
$stats = Show::all()->map(function($s) {
    return [
        'title' => $s->title,
        'duration' => $s->duration_minutes,
        'duration_h' => round(($s->duration_minutes ?? 0) / 60, 2)
    ];
});
```

Пример: взять первые 10 спектаклей и преобразовать для вывода в API:

```php
$payload = Show::with('venue')->paginate(10)->through(function($show) {
    return [
        'id' => $show->id,
        'title' => $show->title,
        'venue' => $show->venue->name ?? null,
    ];
});
```

Эти сниппеты можно положить в контроллеры или сервисы, они демонстрируют filter/groupBy/map/pluck/through.
