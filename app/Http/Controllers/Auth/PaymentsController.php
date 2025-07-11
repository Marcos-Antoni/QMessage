<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Payments;

class PaymentsController extends Controller
{
    public function create(): Response | RedirectResponse
    {
        $user = Auth::user()->name;
        $email = Auth::user()->email;

        $payments = Payments::where('user_id', Auth::user()->id)->first();

        if(!$payments){
            return Inertia::render('PagesProtected/payments', [
                'userEmail' => $email,
            ]);
        }else{
            return to_route('chat');
        }
    }
}
