<?php

namespace App\Providers;

use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\TournamentRepositoryIntarface;
use App\Repositories\PlayerRepository;
use App\Repositories\TournamentRepository;
use Illuminate\Support\ServiceProvider;

class ReporitoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TournamentRepositoryIntarface::class, TournamentRepository::class);
        $this->app->bind(PlayerRepositoryInterface::class, PlayerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
