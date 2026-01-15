<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;

// Halaman depan redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Route Auth
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ticket-create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/ticket-store', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});