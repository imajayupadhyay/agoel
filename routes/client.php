<?php

use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/industries', 'pages.industries')->name('industries');
Route::view('/philanthropy', 'pages.philanthropy')->name('philanthropy');
