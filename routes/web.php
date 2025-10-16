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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', LanguageMiddleware::class])->group(function () {

    Route::post('/chat/start/{user}', [MessengerController::class, 'startOrGetConversation'])->name('chat.start');
    Route::get('/chat/{conversation}', [MessengerController::class, 'showConversation'])->name('chat.show');
    Route::post('/chat/send/{conversation}', [MessengerController::class, 'sendMessage'])->name('chat.send');


    //auth routes
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::patch('/profile/notification/read{id}', [ProfileController::class, 'readNotification'])->name(
        'profile.notification.read',
    );
    Route::get('/profile/myProfile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [ProfileController::class, 'changeAccess'])->name('profile.changeAccess');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/subscriptions', [ProfileController::class, 'subscriptions'])->name('profile.subscriptions');

    //publications routes
    Route::get('/publications', [PublicationController::class, 'publications'])->name('publications');
    Route::get('/publications/sort', [PublicationController::class, 'publications'])->name('publications.sort');
    Route::get('/publications/subscriptions', [PublicationController::class, 'subscriptions'])->name(
        'publications.subscriptions',
    );
    Route::put('/publications/create', [PublicationController::class, 'create'])->name('publications.create');
    Route::post('/publication/like', [PublicationController::class, 'like'])->name('publication.like');
    Route::post('/publication/repost', [PublicationController::class, 'toggleRepost'])->name('publication.repost');
    Route::patch('/publication/hide', [PublicationController::class, 'toggleStatus'])->name('publication.hide');
    Route::get('/publication/edit{id}', [PublicationController::class, 'edit'])->name('publication.edit')->whereNumber(
        'id',
    );
    Route::patch('/publication/update', [PublicationController::class, 'update'])->name('publication.update');
    Route::delete('/publication/destroy{id}', [PublicationController::class, 'destroy'])->name(
        'publication.destroy',
    )->whereNumber('id');

    // publications comments routes
    Route::post('/comment/like', [PublicationCommentController::class, 'toggleLike'])->name('comment.like');
    Route::put('/comment/create', [PublicationCommentController::class, 'storeComment'])->name('comment.create');

    //users routes
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/user/changeSubscription', [UserController::class, 'changeSubscription'])->name(
        'user.changeSubscription',
    );
    Route::get('/users/sort', [UserController::class, 'users'])->name('users.sort');
    Route::get('/users/profile{id}', [UserController::class, 'profile'])->name('users.profile')->whereNumber('id');
    Route::patch('/users/manageSubscribitors', [ProfileController::class, 'manageSubscribitors'])->name(
        'user.manageSubscribitors',
    );
});

// admin routes
Route::middleware(AdminMiddleware::class)->group(function () {
    //admin base route
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    //admin users routes
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/sort', [AdminController::class, 'users'])->name('admin.users.sort');
    Route::delete('/admin/user/block{id}', [AdminController::class, 'blockUser'])->name('admin.user.block');
    Route::get('/admin/user/message{userId?}', [AdminController::class, 'writeMessage'])->name('admin.user.message');
    Route::put('/admin/user/send{sent_to_id}', [AdminController::class, 'sendMessage'])->name('admin.send');

    //admin publications routes
    Route::get('/admin/publications', [AdminController::class, 'publications'])->name('admin.publications');
    Route::get('/admin/publications/sort', [AdminController::class, 'publications'])->name('admin.publications.sort');
    Route::get('/admin/publication/edit{id}', [AdminController::class, 'editPublication'])->name(
        'admin.publication.edit',
    )->whereNumber('id');
    Route::patch('/admin/publication/update', [AdminController::class, 'updatePublication'])->name(
        'admin.publication.update',
    );
    Route::delete('/admin/publication/destroy{id}', [AdminController::class, 'destroyPublication'])->name(
        'admin.publication.destroy',
    )->whereNumber('id');

    //admin comments routes
    Route::get('/admin/comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::get('/admin/comments/sort', [AdminController::class, 'comments'])->name('admin.comments.sort');
    Route::delete('/admin/comment/destroy{id}', [AdminController::class, 'destroyComment'])->name(
        'admin.comment.destroy',
    )->whereNumber('id');
    Route::delete('/admin/publication/destroy{id}', [AdminController::class, 'destroyPublication'])->name(
        'admin.publication.destroy',
    )->whereNumber('id');
});

require __DIR__ . '/auth.php';
