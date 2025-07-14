<?php

namespace App\Services;

use App\Models\Payments;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function processPayment(Request $request): void
    {
        $this->validatePaymentRequest($request);
        
        $body = $this->preparePaymentData($request);
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api-sandboxpayments.qpaypro.com/checkout/api_v1', $body);
        
        $data = $response->json();
        
        if ($data['result'] != 1) {
            throw ValidationException::withMessages([
                'payment' => 'Un dato es incorrecto'
            ]);
        }
        
        $this->createPaymentRecord($body["x_audit_number"]);
    }
    
    protected function validatePaymentRequest(Request $request): void
    {
        $request->validate([
            'name' => 'required|string',
            'card' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'cvc' => 'required|numeric',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip' => 'required|string',
        ]);
    }
    
    protected function preparePaymentData(Request $request): array
    {
        $code = random_int(10000000, 99999999);
        $user = Auth::user();
        
        return [
            "x_login" => config('services.qpay.x_login'),
            "x_private_key" => config('services.qpay.x_private_key'),
            "x_api_secret" => config('services.qpay.x_api_secret'),
            "x_product_id" => 1,
            "x_audit_number" => $code,
            "x_fp_sequence" => $code,
            "x_fp_timestamp" => time(),
            "x_invoice_num" => $code,
            "x_currency_code" => "GTQ",
            "x_amount" => 1.00,
            "x_line_item" => "qmessage<|>w01<|>Mensajes<|>1<|>1.00<|>N",
            "x_freight" => 0.00,
            "x_email" => $user->email,
            "cc_number" => $request->card,
            "cc_exp" => $request->month . '/' . $request->year,
            "cc_cvv2" => $request->cvc,
            "cc_name" => "{$user->first_name} {$user->last_name}",
            "x_first_name" => $user->first_name,
            "x_last_name" => $user->last_name,
            "x_company" => "QMessage",
            "x_address" => "711-2880 Nulla",
            "x_city" => $request->city,
            "x_state" => $request->state,
            "x_country" => $request->country,
            "x_relay_response" => "none",
            "x_zip" => $request->zip,
            "x_relay_url" => "none",
            "x_type" => "AUTH_ONLY",
            "x_method" => "CC",
            "visaencuotas" => 0,
            "origen" => "TESTAPI",
        ];
    }
    
    protected function createPaymentRecord(string $auditNumber): void
    {
        Payments::create([
            'user_id' => Auth::id(),
            'status' => true,
            'transaction_id' => $auditNumber,
        ]);
    }
}
