<?php

use App\Http\Controllers\publication\PublicationCommentController;
use App\Http\Controllers\publication\PublicationController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    //auth routes
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
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
    Route::get('/publications/subscriptions', [PublicationController::class, 'subscriptions'])->name('publications.subscriptions');
    Route::put('/publications/create', [PublicationController::class, 'create'])->name('publications.create');
    Route::post('/publication/like', [PublicationController::class, 'like'])->name('publication.like');
    Route::post('/publication/repost', [PublicationController::class, 'repost'])->name('publication.repost');
    Route::patch('/publication/hide', [PublicationController::class, 'hide'])->name('publication.hide');
    Route::get('/publication/edit{id}', [PublicationController::class, 'edit'])->name('publication.edit')->whereNumber('id');
    Route::patch('/publication/update', [PublicationController::class, 'update'])->name('publication.update');

    // publications comments routes
    Route::post('/comment/like', [PublicationCommentController::class, 'like'])->name('comment.like');
    Route::put('/comment/create', [PublicationCommentController::class, 'storeComment'])->name('comment.create');

    //users routes
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/user/changeSubscription', [UserController::class, 'changeSubscription'])->name('user.changeSubscription');
    Route::get('/users/sort', [UserController::class, 'users'])->name('users.sort');
    Route::get('/users/profile{id}', [UserController::class, 'profile'])->name('users.profile')->whereNumber('id');
    Route::patch('/users/manageSubscribitors', [ProfileController::class, 'manageSubscribitors'])->name('user.manageSubscribitors');

});

require __DIR__.'/auth.php';
