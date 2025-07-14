<?php

namespace App\Http\Controllers\Private;

use App\Events\ChatEventClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

use App\Models\Payments;
use App\Services\ChatService;

class ChatController extends Controller
{

    public function __construct(
        private ChatService $chatService
    ){}

    public function create(): Response | RedirectResponse
    {
        $payments = Payments::where('user_id', Auth::user()->id)->first();

        if(!$payments) return to_route('payments');

        $messages = $this->chatService->messages();

        return Inertia::render('PagesProtected/Chat', [
            'messages' => $messages,
        ]);
    }


    public function store(Request $request): void
    {
        $message = $request->message;
        $user = Auth::user()->id;

        $this->chatService->createMessages($message);

        event(new ChatEventClass($message, $user));
    }
}
