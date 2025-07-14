<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    public function messages(){
        $ultimosMensajesPuros = Chat::latest()->limit(100)->get();

        $ultimosMensajesEstructurados = $ultimosMensajesPuros->map(function($message) {
            $user = User::find($message->user_id);

            return $this->builderMessages($message, $user);
        });

        return array_reverse($ultimosMensajesEstructurados->toArray());
    }

    private function builderMessages(Chat $message, User $user){
        return [
            'id' => $message->id,
            'user_id' => $message->user_id,
            'username' => $user->first_name . ' ' . $user->last_name,
            'message' => $message->message,
            'timestamp' => $message->created_at->format('H:i A'),
            'avatar' => ucfirst($user->first_name[0])
        ];
    }

    public function createMessages($message): void
    {
        $user = Auth::user()->id;

        Chat::create([
            'user_id' => $user,
            'message' => $message,
        ]);
    }
}
