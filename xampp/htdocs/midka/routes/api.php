<?php
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

Route::get('/vacancies',            [VacancyController::class, 'apiIndex']);
Route::get('/vacancies/{vacancy}',  [VacancyController::class, 'apiShow']);

Route::middleware(['auth:sanctum', 'role:employer,admin'])->group(function () {
    Route::post('/vacancies', [VacancyController::class, 'apiStore']);
});

Route::middleware(['auth:sanctum', 'role:employer,moderator,admin'])->group(function () {
    Route::put('/vacancies/{vacancy}',    [VacancyController::class, 'apiUpdate']);
    Route::delete('/vacancies/{vacancy}', [VacancyController::class, 'apiDestroy']);
});