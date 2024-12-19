<?php

namespace App\Providers;

use App\Services\ReportService;
use App\Contracts\ReportServiceContract;
use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ReportServiceContract::class, ReportService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
