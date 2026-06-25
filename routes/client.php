<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\IndustriesController;
use App\Http\Controllers\Client\PhilanthropyController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/industries', IndustriesController::class)->name('industries');
Route::get('/philanthropy', PhilanthropyController::class)->name('philanthropy');
