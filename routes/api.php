<?php

use App\Http\Controllers\Api\PublicationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiMiddleware;


Route::prefix('v1')->middleware(ApiMiddleware::class)->group(function () {
    // Custom route to get publications by user
    Route::get('/user/{id}/publications', [PublicationController::class, 'getListByUser'])->name('user.publications');
    Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
    Route::post('/user/{id}/publications', [PublicationController::class, 'store'])->name('publications.store');
    Route::get('/publications/{id}', [PublicationController::class, 'show'])->name('publications.show');
    Route::put('/publications/{publicationId}', [PublicationController::class, 'update'])->name('publications.update');
    Route::delete('/publications/{id}', [PublicationController::class, 'destroy'])->name('publications.destroy');
});

