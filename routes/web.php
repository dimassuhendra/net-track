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
use App\Models\Notification;

// --- GUEST ROUTE (Hanya untuk yang BELUM Login) ---
Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect('/login'));
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

// --- AUTH ROUTE (Hanya untuk yang SUDAH Login) ---
Route::middleware('auth')->group(function () {

    // 1. Akses Umum (Semua Role: Admin, Staff, Manager, GM)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Audit Log sekarang dipindah ke sini agar semua role yang sudah login bisa akses
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');

    // Route Notifikasi
    Route::post('/notifications/read/{id}', function ($id) {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    })->name('notifications.read');

    // --- GRUP OPERASIONAL ---
    Route::middleware(['can:access-operasional'])->group(function () {
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

        Route::middleware(['can:create-ticket'])->group(function () {
            Route::get('/ticket-create', [TicketController::class, 'create'])->name('tickets.create');
            Route::post('/ticket-store', [TicketController::class, 'store'])->name('tickets.store');
        });

        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    });

    // --- GRUP MASTER DATA ---
    Route::middleware(['can:access-master'])->group(function () {
        Route::resource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
        Route::resource('customers', CustomerController::class)->except(['create', 'edit', 'show']);
    });

    // --- GRUP LAPORAN ---
    Route::middleware(['can:access-reports'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    });

    // --- GRUP SISTEM ADMIN ---
    Route::middleware(['can:is-admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});