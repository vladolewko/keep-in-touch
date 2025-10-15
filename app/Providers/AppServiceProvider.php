<?php

namespace App\Providers;

use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\ICommentRepositoryInterface;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Repositories\Interfaces\ISubscriptionRepositoryInterface;
use App\Repositories\Interfaces\IUserPublicationLikeRepositoryInterface;
use App\Repositories\Interfaces\IUserRepositoryInterface;
use App\Repositories\PublicationRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\UserPublicationLikeRepository;
use App\Repositories\UserRepository;
use App\Services\CommentService;
use App\Services\Interfaces\ICommentServiceInterface;
use App\Services\Interfaces\INotificationServiceInterface;
use App\Services\Interfaces\IPublicationServiceInterface;
use App\Services\Interfaces\ISubscriptionServiceInterface;
use App\Services\Interfaces\IUserPublicationLikeServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use App\Services\NotificationService;
use App\Services\PublicationService;
use App\Services\SubscriptionService;
use App\Services\UserPublicationLikeService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IPublicationRepositoryInterface::class, PublicationRepository::class);
        $this->app->bind(IUserPublicationLikeRepositoryInterface::class, UserPublicationLikeRepository::class);
        $this->app->bind(IUserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ICommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(ISubscriptionRepositoryInterface::class, SubscriptionRepository::class);

        $this->app->bind(IUserPublicationLikeServiceInterface::class, UserPublicationLikeService::class);
        $this->app->bind(IUserServiceInterface::class, UserService::class);
        $this->app->bind(ISubscriptionServiceInterface::class, SubscriptionService::class);
        $this->app->bind(IPublicationServiceInterface::class, PublicationService::class);
        $this->app->bind(INotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(ICommentServiceInterface::class, CommentService::class);

    }

    public function boot(): void
    {
    }
}
