<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\UserController;

// Guest Route
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect('/login'));
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// Auth Route
Route::middleware('auth')->group(function () {

    // Semua role bisa akses Dashboard & Logout
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- GRUP OPERASIONAL ---
    // (Admin, Staff, Manager IT)
    Route::middleware(['can:access-operasional'])->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

        // Khusus Input Tiket (Hanya Admin & Staff sesuai Sidebar Anda)
        Route::middleware(['can:create-ticket'])->group(function () {
            Route::get('/ticket-create', [TicketController::class, 'create'])->name('tickets.create');
            Route::post('/ticket-store', [TicketController::class, 'store'])->name('tickets.store');
        });

        // Khusus Delete Tiket (Opsional: Biasanya Admin/Manager)
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

    // --- GRUP MASTER DATA ---
    // (Admin, Manager IT)
    Route::middleware(['can:access-master'])->group(function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
        Route::resource('customers', CustomerController::class)->except(['create', 'edit', 'show']);
    });

    // --- GRUP LAPORAN ---
    // (Admin, Manager IT, GM)
    Route::middleware(['can:access-reports'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    });

    // --- GRUP SISTEM ADMIN ---
    // (Hanya Admin)
    Route::middleware(['can:is-admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    });
});