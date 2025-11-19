<?php

use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Account\FavoriteController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogDetailController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, "index"])->name('index');

//
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::post('/dashboard/password', [DashboardController::class, 'updatePassword'])->name('dashboard.password.update');
    Route::post('/favorites/{post}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::prefix('auth')->as("auth.")->group(function () {
    Route::controller(RegisterController::class)->as('register.')->prefix('register')->middleware("guest")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'post')->name('post');
    });

    Route::controller(LoginController::class)->as('login.')->prefix('login')->middleware("guest")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'post')->name('post');
    });

    Route::post("/logout", [LogoutController::class, "index"])->middleware("auth")->name('logout');
});
Route::controller(BlogDetailController::class)->as('blog-detail.')->prefix('blog')->group(function () {
    Route::get('/{id}', 'index')->name('index');
    Route::post('/comment', 'storeComment')->name('comment');
});

Route::prefix("admin")->as("admin.")->middleware("auth")->group(function () {
    Route::controller(AdminPanelController::class)->as('panel.')->prefix('panel')->middleware("auth")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'post')->name('post');
    });

});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('panel', [App\Http\Controllers\Admin\AdminPanelController::class, 'index'])->name('panel');
    Route::get('users/{user}/edit', [App\Http\Controllers\Admin\AdminPanelController::class, 'edit'])->name('edit');
    Route::put('users/{user}/profile', [App\Http\Controllers\Admin\AdminPanelController::class, 'update'])->name('update');
    Route::delete('users/{user}', [App\Http\Controllers\Admin\AdminPanelController::class, 'destroy'])->name('destroy');
    Route::post('users/{user}/make-admin', [App\Http\Controllers\Admin\AdminPanelController::class, 'toggleAdmin'])->name('toggle-admin');
});
