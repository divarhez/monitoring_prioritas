<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\MaintenanceSchedule;
use App\Observers\MaintenanceScheduleObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap pagination views for links()
        Paginator::useBootstrap();

        // Register model observers
        MaintenanceSchedule::observe(MaintenanceScheduleObserver::class);
    }
}
