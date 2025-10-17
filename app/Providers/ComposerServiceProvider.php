<?php

namespace App\Providers;

use App\View\Composers\UnreadNotificationsComposer;
use App\View\Composers\UnreadMessagesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.navigation', UnreadMessagesComposer::class);
        View::composer('layouts.navigation', UnreadNotificationsComposer::class);
    }
}