<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\IndustriesController;
use App\Http\Controllers\Admin\PhilanthropyController;
use Illuminate\Support\Facades\Route;

Route::prefix('sanchalak')->group(function () {
    Route::get('/', [AuthController::class, 'create'])->name('login');
    Route::post('/', [AuthController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
        Route::get('/homepage', [HomepageController::class, 'edit'])->name('admin.homepage.edit');
        Route::put('/homepage', [HomepageController::class, 'update'])->name('admin.homepage.update');
        Route::post('/homepage/sections', [HomepageController::class, 'storeSection'])->name('admin.homepage.sections.store');
        Route::delete('/homepage/sections/{section}', [HomepageController::class, 'destroySection'])->name('admin.homepage.sections.destroy');
        Route::get('/industries', [IndustriesController::class, 'edit'])->name('admin.industries.edit');
        Route::put('/industries', [IndustriesController::class, 'update'])->name('admin.industries.update');
        Route::post('/industries/items', [IndustriesController::class, 'storeIndustry'])->name('admin.industries.items.store');
        Route::delete('/industries/items/{industry}', [IndustriesController::class, 'destroyIndustry'])->name('admin.industries.items.destroy');
        Route::get('/philanthropy', [PhilanthropyController::class, 'edit'])->name('admin.philanthropy.edit');
        Route::put('/philanthropy', [PhilanthropyController::class, 'update'])->name('admin.philanthropy.update');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
    });
});
