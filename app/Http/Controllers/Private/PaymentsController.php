<?php

namespace App\Http\Controllers\Private;

use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Payments;

class PaymentsController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ){}

    public function create(): Response | RedirectResponse
    {
        $payments = Payments::where('user_id', Auth::id())->exists();
        
        if ($payments) {
            return to_route('chat');
        }

        return Inertia::render('PagesProtected/Payments');
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->paymentService->processPayment($request);
            return to_route('chat');
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'payment' => 'Ocurrió un error al procesar el pago. Por favor, verifica tus datos e inténtalo de nuevo.'
            ]);
        }
    }
}
