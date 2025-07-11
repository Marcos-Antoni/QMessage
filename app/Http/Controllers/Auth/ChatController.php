<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Payments;

class ChatController extends Controller
{
    public function create(): Response | RedirectResponse
    {
        $email = Auth::user()->email;
        $payments = Payments::where('user_id', Auth::user()->id)->first();

        if($payments && $payments->status){
            return Inertia::render('PagesProtected/Chat', [
                'userEmail' => $email,
            ]);
        }else{
            return to_route('payments');
        }

    }
}
