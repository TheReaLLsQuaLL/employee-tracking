<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkingHoursController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StatsController;

Route::get('/', [WorkingHoursController::class, 'index'])->name('dashboard.index');
Route::get('/create-new', [WorkingHoursController::class, 'create'])->name('dashboard.create');
Route::post('/create-new', [WorkingHoursController::class, 'store'])->name('dashboard.start');
Route::get('/edit/{id}', [WorkingHoursController::class, 'edit'])->name('dashboard.edit');
Route::put('/update/{id}', [WorkingHoursController::class, 'update'])->name('dashboard.update');
Route::post('/stop', [WorkingHoursController::class, 'stop'])->name('dashboard.stop');
Route::post('/delete', [WorkingHoursController::class, 'destroy'])->name('dashboard.delete');
Route::post('/delete', [WorkingHoursController::class, 'destroy'])->name('dashboard.delete');
Route::get('/create-project', [ProjectController::class, 'index'])->name('project.create');
Route::post('/create-project', [ProjectController::class, 'store'])->name('project.store');
Route::get('/stats', [StatsController::class, 'index'])->name('stats.index');
