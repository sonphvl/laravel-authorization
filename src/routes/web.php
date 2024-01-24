<?php

use Illuminate\Support\Facades\Route;
use Sonphvl\Authorization\Controllers\AuthorizationController;

Route::get('/authorization', [AuthorizationController::class, 'index']);
Route::post('/authorization', [AuthorizationController::class, 'update'])->name('authorization.update');
