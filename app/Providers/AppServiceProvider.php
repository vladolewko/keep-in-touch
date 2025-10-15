<?php

namespace App\Providers;

use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Repositories\Interfaces\IUserPublicationLikeRepositoryInterface;
use App\Repositories\PublicationRepository;
use App\Repositories\UserPublicationLikeRepository;
use App\Services\Interfaces\IPublicationServiceInterface;
use App\Services\Interfaces\IUserPublicationLikeServiceInterface;
use App\Services\PublicationService;
use App\Services\UserPublicationLikeService;
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
        $this->app->bind(IUserPublicationLikeRepositoryInterface::class, UserPublicationLikeRepository::class);
        $this->app->bind(IUserPublicationLikeServiceInterface::class, UserPublicationLikeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
