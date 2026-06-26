<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.research');
    }
}
