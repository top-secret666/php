<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;

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

// Admin-protected routes example
Route::middleware([AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return 'admin';
    })->name('dashboard');
});

// Minimal authentication routes (simple login/register/logout) — replace full Auth::routes() for this dev scaffold
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
