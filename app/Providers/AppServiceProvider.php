<?php

namespace App\Providers;

use App\Repositories\SummaryRepositoryInterface;
use App\Repositories\SummaryRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SummaryRepositoryInterface::class, SummaryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
