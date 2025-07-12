<?php

namespace App\Http\Controllers\Private;

use App\Events\ChatEventClass;
use App\Events\OrderShipmentStatusUpdated;
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

    public function store(): void
    {
        $codigo = random_int(10000000, 99999999);
        $message = 'hola ' . $codigo;
        $user = Auth::user()->email;
        
        // event(new \App\Events\OrderShipmentStatusUpdated(Auth::user()->id, 'Mensaje de prueba'));

        event(new OrderShipmentStatusUpdated($codigo, $message));
        // OrderShipmentStatusUpdated::dispatch($codigo, $message);
    }
}
