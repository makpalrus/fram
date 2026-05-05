<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\LocalizationController;

Route::middleware(['web'])->group(function () {

    Route::get('/lang/{lang}', [LocalizationController::class, 'index'])
        ->where('lang', 'en|kz|ru')
        ->name('lang.switch');

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

    Route::middleware('auth')->group(function () {

        Route::get('/vacancies', [VacancyController::class, 'index']);
        Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show']);

        Route::middleware('role:employer,admin')->group(function () {
            Route::get('/vacancies/create', [VacancyController::class, 'create']);
            Route::post('/vacancies', [VacancyController::class, 'store']);
        });

        Route::middleware('role:employer,moderator,admin')->group(function () {
            Route::get('/vacancies/{vacancy}/edit', [VacancyController::class, 'edit']);
            Route::put('/vacancies/{vacancy}', [VacancyController::class, 'update']);
            Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'destroy']);
        });

        Route::middleware('role:student')->group(function () {
            Route::get('/vacancies/{vacancy}/apply', [ApplicationController::class, 'create']);
            Route::post('/vacancies/{vacancy}/apply', [ApplicationController::class, 'store']);
        });

        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', [AdminController::class, 'index']);
        });

        Route::get('/mail/send', [MailController::class, 'send']);
    });
});