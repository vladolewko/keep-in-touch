<?php

namespace App\Providers;

use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Repositories\PublicationRepository;
use App\Services\Interfaces\IPublicationServiceInterface;
use App\Services\PublicationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IPublicationRepositoryInterface::class, PublicationRepository::class);
        $this->app->bind(IPublicationServiceInterface::class, PublicationService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
