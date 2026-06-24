<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/industries', 'pages.industries')->name('industries');
Route::view('/philanthropy', 'pages.philanthropy')->name('philanthropy');

Route::prefix('sanchalak')->group(function () {
    Route::get('/', [AuthController::class, 'create'])->name('login');
    Route::post('/', [AuthController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('admin.login.store');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('admin.logout');
    });
});

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml; charset=UTF-8');
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\nDisallow: /sanchalak\nSitemap: ".route('sitemap')."\n",
        200,
        ['Content-Type' => 'text/plain; charset=UTF-8'],
    );
});

Route::permanentRedirect('/F1_Anmolweb-D.html', '/');
Route::permanentRedirect('/F1 Anmolweb-D.html', '/');
Route::permanentRedirect('/F2_Anmolweb-Industries.html', '/industries');
Route::permanentRedirect('/F3_Anmolweb-Industries (1).html', '/industries');
Route::permanentRedirect('/F3_Anmolweb-Philanthropy.html', '/philanthropy');
