<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function create(): Response
    {

        $isLogged = !!Auth::user();

        return Inertia::render('Home',[
            'isLogged' => $isLogged
        ]);
    }
}
