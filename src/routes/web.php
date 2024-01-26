<?php

use Illuminate\Support\Facades\Route;
use Sonphvl\Authorization\Controllers\AuthorizationController;

Route::group(['middleware' => 'web'], function () {
    Route::get('/authorization', [AuthorizationController::class, 'index'])->name('authorization.index');
    Route::post('/authorization', [AuthorizationController::class, 'update']);
});