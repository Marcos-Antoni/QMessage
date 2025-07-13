<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Home');
    }
}
