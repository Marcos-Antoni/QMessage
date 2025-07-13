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
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function create(): Response | RedirectResponse
    {
        $email = Auth::user()->email;
        $payments = Payments::where('user_id', Auth::user()->id)->first();

        if($payments && $payments->status){
            $messages = $this->messages();

            return Inertia::render('PagesProtected/Chat', [
                'messages' => $messages,
            ]);
        }else{
            return to_route('payments');
        }

    }

    public function messages(){
        $ultimosMensajesPuros = Chat::latest()->limit(100)->get();

        $ultimosMensajesEstructurados = $ultimosMensajesPuros->map(function($message){
            $user = User::find($message->user_id);

            return [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'username' => $user->first_name . ' ' . $user->last_name,
                'message' => $message->message,
                'timestamp' => $message->created_at->format('H:i A'),
                'avatar' => ucfirst($user->first_name[0])
            ];
        });

        return array_reverse($ultimosMensajesEstructurados->toArray());
    }

    public function store(Request $request): void
    {
        $message = $request->message;
        $user = Auth::user()->id;

        Chat::create([
            'user_id' => $user,
            'message' => $message,
        ]);

        // event(new \App\Events\OrderShipmentStatusUpdated(Auth::user()->id, 'Mensaje de prueba'));
        // OrderShipmentStatusUpdated::dispatch($codigo, $message);

        event(new ChatEventClass($message, $user));
    }
}
