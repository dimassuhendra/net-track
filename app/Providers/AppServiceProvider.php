<?php
namespace App\Providers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\User;
use App\Observers\ActivityObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Ticket::observe(ActivityObserver::class);
        Customer::observe(ActivityObserver::class);
        Category::observe(ActivityObserver::class);
        User::observe(ActivityObserver::class);
    }
}