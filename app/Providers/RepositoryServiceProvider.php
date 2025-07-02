<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\StatisticsService;
use App\Repositories\BeritaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(StatisticsService::class, function ($app) {
            return new StatisticsService();
        });

        $this->app->singleton(BeritaRepository::class, function ($app) {
            return new BeritaRepository($app->make('App\Models\Berita'));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 