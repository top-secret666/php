<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('shows.index');
})->name('home');

// Example books resource (from task template)
use App\Http\Controllers\BookController;
Route::resource('books', BookController::class);
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

Route::resource('shows', ShowController::class);
Route::get('/shows/search', [ShowController::class, 'search'])->name('shows.search');

Route::resource('performances', PerformanceController::class);
Route::resource('tickets', TicketController::class);
Route::resource('orders', OrderController::class);

// Authentication routes
Auth::routes();
