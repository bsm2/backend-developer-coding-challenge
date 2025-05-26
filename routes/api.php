<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ProfileController;
use App\Http\Controllers\Api\PlatformController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout',  [AuthController::class, 'logout'])->middleware('auth:api');
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
    Route::put('/password', [ProfileController::class, 'changePassword']);

    Route::apiResource('posts', PostController::class);

    Route::get('platforms', [PlatformController::class, 'index']);
    Route::post('platforms', [PlatformController::class, 'toggle']);
});
