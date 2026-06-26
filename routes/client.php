<?php

use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\BooksController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\IndustriesController;
use App\Http\Controllers\Client\NewsController;
use App\Http\Controllers\Client\PhilanthropyController;
use App\Http\Controllers\Client\ResearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/industries', IndustriesController::class)->name('industries');
Route::get('/philanthropy', PhilanthropyController::class)->name('philanthropy');
Route::get('/in-the-news', NewsController::class)->name('news');
Route::get('/books', BooksController::class)->name('books');
Route::get('/research-publications', ResearchController::class)->name('research');
Route::get('/about-anmol-goel', AboutController::class)->name('about');
