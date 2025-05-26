<?php

use App\Http\Controllers\PostController;
use App\Livewire\Platforms\Settings;
use App\Livewire\Posts\Analytics;
use App\Livewire\Posts\Calendar;
use App\Livewire\Posts\Edit;
use App\Livewire\Posts\Index;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/posts', Index::class)->name('posts.index');
    Route::get('/posts/{post}/edit', Edit::class)->name('posts.edit');
    Route::get('/analytics', Analytics::class)->name('analytics');
    Route::get('/calendar', Calendar::class)->name('calendar');
    Route::get('/platforms/settings', Settings::class)->name('platforms.settings');
    Route::get('/calendar-events', [Calendar::class, 'posts'])->name('calendar.posts');
});

require __DIR__ . '/auth.php';
