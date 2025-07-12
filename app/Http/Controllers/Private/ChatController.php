<?php

namespace App\Http\Controllers\Private;

use App\Events\ChatEventClass;
use App\Events\OrderShipmentStatusUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function store(Request $request): void
    {
        
        $message = $request->message;
        $user = Auth::user()->email;
        
        // event(new \App\Events\OrderShipmentStatusUpdated(Auth::user()->id, 'Mensaje de prueba'));
        // OrderShipmentStatusUpdated::dispatch($codigo, $message);

        event(new ChatEventClass($message, $user));
    }
}
