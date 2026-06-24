<?php

use Illuminate\Support\Facades\Route;

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
