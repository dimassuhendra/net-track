<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Kebijakan (Policies) aplikasi.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Daftarkan layanan otentikasi / otorisasi apa pun.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // 1. Gate Operasional (Admin, Staff, Manager IT)
        Gate::define('access-operasional', function (User $user) {
            return in_array($user->role, ['admin', 'staff', 'manager_it']);
        });

        // 2. Gate Input Tiket (Hanya Admin & Staff)
        Gate::define('create-ticket', function (User $user) {
            return in_array($user->role, ['admin', 'staff']);
        });

        // 3. Gate Master Data (Admin, Manager IT)
        Gate::define('access-master', function (User $user) {
            return in_array($user->role, ['admin', 'manager_it']);
        });

        // 4. Gate Laporan (Admin, Manager IT, GM)
        Gate::define('access-reports', function (User $user) {
            return in_array($user->role, ['admin', 'manager_it', 'gm']);
        });

        // 5. Gate Sistem Admin (Hanya Admin)
        Gate::define('is-admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}