<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\IndustriesController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\PhilanthropyController;
use App\Http\Controllers\Admin\ResearchController;
use App\Http\Controllers\Admin\SeoSettingsController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('edit99')->group(function () {
    Route::get('/', [AuthController::class, 'create'])->name('login');
    Route::post('/', [AuthController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
        Route::get('/header', [HeaderController::class, 'edit'])->name('admin.header.edit');
        Route::put('/header', [HeaderController::class, 'update'])->name('admin.header.update');
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
        Route::get('/in-the-news', [NewsController::class, 'edit'])->name('admin.news.edit');
        Route::put('/in-the-news', [NewsController::class, 'update'])->name('admin.news.update');
        Route::get('/newsletters', [NewsletterController::class, 'index'])->name('admin.newsletters.index');
        Route::patch('/newsletters/{subscriber}', [NewsletterController::class, 'updateStatus'])->name('admin.newsletters.update');
        Route::delete('/newsletters/{subscriber}', [NewsletterController::class, 'destroy'])->name('admin.newsletters.destroy');
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('admin.users.password.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/books', [BooksController::class, 'edit'])->name('admin.books.edit');
        Route::put('/books', [BooksController::class, 'update'])->name('admin.books.update');
        Route::get('/research-publications', [ResearchController::class, 'edit'])->name('admin.research.edit');
        Route::put('/research-publications', [ResearchController::class, 'update'])->name('admin.research.update');
        Route::post('/research-publications/publications', [ResearchController::class, 'storePublication'])->name('admin.research.publications.store');
        Route::delete('/research-publications/publications/{publication}', [ResearchController::class, 'destroyPublication'])->name('admin.research.publications.destroy');
        Route::get('/research-publications/categories', [ResearchController::class, 'editCategories'])->name('admin.research.categories.edit');
        Route::put('/research-publications/categories', [ResearchController::class, 'updateCategories'])->name('admin.research.categories.update');
        Route::post('/research-publications/categories', [ResearchController::class, 'storeCategory'])->name('admin.research.categories.store');
        Route::delete('/research-publications/categories/{category}', [ResearchController::class, 'destroyCategory'])->name('admin.research.categories.destroy');
        Route::get('/about-anmol-goel', [AboutController::class, 'edit'])->name('admin.about.edit');
        Route::put('/about-anmol-goel', [AboutController::class, 'update'])->name('admin.about.update');
        Route::get('/seo', [SeoSettingsController::class, 'edit'])->name('admin.seo.edit');
        Route::put('/seo', [SeoSettingsController::class, 'update'])->name('admin.seo.update');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
    });
});
