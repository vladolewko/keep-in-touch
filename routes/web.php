<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\Publication\PublicationCommentController;
use App\Http\Controllers\Publication\PublicationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\LanguageMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware(['auth', LanguageMiddleware::class])->group(function () {
    Route::get('/chats', [MessengerController::class, 'index'])->name('chats.index');

    Route::prefix('chat')->group(function () {
        Route::post('/start/{user}', [MessengerController::class, 'startOrGetConversation'])->name('chat.start');
        Route::get('/{conversation}', [MessengerController::class, 'showConversation'])->name('chat.show');
        Route::post('/send/{conversation}', [MessengerController::class, 'sendMessage'])->name('chat.send');
        Route::delete('/destroy/{conversation}', [MessengerController::class, 'destroy'])->name('chat.destroy');
        Route::patch('/{conversation}/read', [MessengerController::class, 'markAsRead'])->name('chat.read');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
        Route::patch('/notification/read{id}', [ProfileController::class, 'readNotification'])->name('profile.notification.read');
        Route::get('/myProfile', [ProfileController::class, 'profile'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/changeAccess', [ProfileController::class, 'changeAccess'])->name('profile.changeAccess');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/followers', [ProfileController::class, 'followers'])->name('profile.followers');
        Route::get('/subscriptions', [ProfileController::class, 'subscriptions'])->name('profile.subscriptions');
    });

    Route::prefix('publications')->group(function () {
        Route::get('/all', [PublicationController::class, 'publications'])->name('publications');
        Route::get('/sort', [PublicationController::class, 'publications'])->name('publications.sort');
    });

    Route::prefix('publication')->group(function () {
        Route::put('/create', [PublicationController::class, 'create'])->name('publication.create');
        Route::post('/like', [PublicationController::class, 'like'])->name('publication.like');
        Route::post('/repost', [PublicationController::class, 'toggleRepost'])->name('publication.repost');
        Route::patch('/hide', [PublicationController::class, 'toggleStatus'])->name('publication.hide');
        Route::get('/edit{id}', [PublicationController::class, 'edit'])->name('publication.edit');
        Route::patch('/update', [PublicationController::class, 'update'])->name('publication.update');
        Route::delete('/destroy{id}', [PublicationController::class, 'destroy'])->name('publication.destroy');
    });

    Route::prefix('comment')->group(function () {
        Route::post('/like', [PublicationCommentController::class, 'toggleLike'])->name('comment.like');
        Route::put('/create', [PublicationCommentController::class, 'storeComment'])->name('comment.create');
    });

    Route::prefix('user')->group(function () {
        Route::post('/changeSubscription', [UserController::class, 'changeSubscription'])->name('user.changeSubscription');
    });

    Route::prefix('users')->group(function () {
        Route::get('/all', [UserController::class, 'users'])->name('users');
        Route::get('/sort', [UserController::class, 'users'])->name('users.sort');
        Route::get('/profile{id}', [UserController::class, 'profile'])->name('users.profile');
        Route::patch('/manageSubscribitors', [ProfileController::class, 'manageSubscribitors'])->name('user.manageSubscribitors');
    });
});

Route::middleware(AdminMiddleware::class)->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/all', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/sort', [AdminController::class, 'users'])->name('admin.users.sort');
    });

    Route::prefix('user')->group(function () {
        Route::delete('/block{id}', [AdminController::class, 'blockUser'])->name('admin.user.block');
        Route::get('/message{userId?}', [AdminController::class, 'writeMessage'])->name('admin.user.message');
        Route::put('/send{sent_to_id}', [AdminController::class, 'sendMessage'])->name('admin.send');
    });

    Route::prefix('publications')->group(function () {
        Route::get('/all', [AdminController::class, 'publications'])->name('admin.publications');
        Route::get('/sort', [AdminController::class, 'publications'])->name('admin.publications.sort');
    });

    Route::prefix('publication')->group(function () {
        //    Route::get('/edit{id}', [AdminController::class, 'editPublication'])->name('admin.publication.edit');
        //    Route::patch('/update', [AdminController::class, 'updatePublication'])->name('admin.publication.update');
        Route::delete('/destroy{id}', [AdminController::class, 'destroyPublication'])->name('admin.publication.destroy');
    });

    Route::prefix('comments')->group(function () {
        Route::get('/all', [AdminController::class, 'comments'])->name('admin.comments');
        Route::get('/sort', [AdminController::class, 'comments'])->name('admin.comments.sort');
    });

    Route::prefix('comment')->group(function () {
        Route::delete('/comment/destroy{id}', [AdminController::class, 'destroyComment'])->name('admin.comment.destroy');
    });
});

require __DIR__ . '/auth.php';
