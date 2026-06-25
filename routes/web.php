<?php

use App\Http\Controllers\Client\SeoFilesController;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SeoFilesController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoFilesController::class, 'robots'])->name('robots');

Route::permanentRedirect('/F1_Anmolweb-D.html', '/');
Route::permanentRedirect('/F1 Anmolweb-D.html', '/');
Route::permanentRedirect('/F2_Anmolweb-Industries.html', '/industries');
Route::permanentRedirect('/F3_Anmolweb-Industries (1).html', '/industries');
Route::permanentRedirect('/F3_Anmolweb-Philanthropy.html', '/philanthropy');
