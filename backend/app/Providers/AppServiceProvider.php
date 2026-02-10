<?php

namespace App\Providers;

use App\Repositories\Contracts\EventRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
