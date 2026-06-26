<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class BooksController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.books');
    }
}
