<?php

namespace App\Http\Controllers\Private;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Inertia\Response;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


use App\Http\Controllers\Controller;
use App\Models\Payments;

class PaymentsController extends Controller
{
    public function create(): Response | RedirectResponse
    {
        $email = Auth::user()->email;

        $payments = Payments::where('user_id', Auth::user()->id)->first();

        if(!$payments){
            return Inertia::render('PagesProtected/Payments', [
                'userEmail' => $email,
            ]);
        }else{
            return to_route('chat');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        try {       
            $request->validate([
                'name' => 'required|string',
                'card' => 'required|numeric',
                'month' => 'required|numeric',
                'year' => 'required|numeric',
                'cvc' => 'required|numeric',
            ]);

            $body = $this->bootqpay($request);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api-sandboxpayments.qpaypro.com/checkout/api_v1', 
                $body
            );

            
            $data = $response->json();
            
            if($data['result'] == 1){
                Payments::create([
                    'user_id' => Auth::user()->id,
                    'status' => true,
                    'transaction_id' => $body["x_audit_number"],
                ]);
                return to_route('chat');
            }else{
                throw ValidationException::withMessages([
                    'payment' => 'Un dato es incorrecto'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error en store: ' . $e->getMessage());
            throw ValidationException::withMessages([
                'payment' => $e->getMessage()
            ]);
        }
    }

    public function bootqpay(Request $request)
    {

        $codigo = random_int(10000000, 99999999);
        return [
            "x_login" => env('X_LOGIN'),
            "x_private_key" => env('X_PRIVATE_KEY'),
            "x_api_secret" => env('X_API_SECRET'),
            "x_product_id" => 1,
            "x_audit_number" => $codigo, // codigo de compra
            "x_fp_sequence" => $codigo, // es igual que el de arriba
            "x_fp_timestamp" => time(), // Fecha exacta en formato timestamp UNIX
            "x_invoice_num" => $codigo, // numero de factura
            "x_currency_code" => "GTQ", // moneda
            "x_amount" => 1.00, // monto total
            "x_line_item" => "qmessage<|>w01<|>Mensajes<|>1<|>1.00<|>N", // descripcion del producto
            "x_freight" => 0.00, // costo de envio
            "x_email" => Auth::user()->email, // correo del cliente
            "cc_number" => $request->card, // numero de tarjeta
            "cc_exp" => $request->month . '/' . $request->year, // fecha de expiracion
            "cc_cvv2" => $request->cvc, // codigo de seguridad
            "cc_name" => Auth::user()->first_name . ' ' . Auth::user()->last_name, // nombre del titular
            "x_first_name" => Auth::user()->first_name, // nombre del cliente
            "x_last_name" => Auth::user()->last_name, // apellido del cliente
            "x_company" => "QMessage", // nombre de la empresa
            "x_address" => "711-2880 Nulla", // direccion del cliente
            "x_city" => "Guatemala", // ciudad del cliente
            "x_state" => "Guatemala", // estado del cliente
            "x_country" => "Guatemala", // pais del cliente
            "x_relay_response" => "none", // respuesta de la transaccion
            "x_zip" => "01056", // codigo postal del cliente
            "x_relay_url" => "none", // url de la transaccion
            "x_type" => "AUTH_ONLY", // tipo de transaccion
            "x_method" => "CC", // metodo de pago
            "visaencuotas" => 0, // numero de cuotas
            "origen" => "TESTAPI", // origen de la transaccion
        ];
    }

    // public function processPayment(Request $request)
    // {
    //     try {
            

    //         // Verificar si la petición fue exitosa
    //         if ($response->successful()) {
    //             $responseData = $response->json();
                
    //             // Aquí procesas la respuesta del servidor de pagos
    //             if ($responseData['result'] === 1) { // Ajusta según la respuesta real
    //                 return $responseData;
    //             }
    //         }

    //         // Si hay algún error
    //         return back()->with('error', 'Error al procesar el pago');
            
    //     } catch (\Exception $e ) {
    //         Log::error('Error en el proceso de pago: ' . $e->getMessage());
    //         return back()->with('error', 'Ocurrió un error al procesar el pago');
    //     }
    // }

}
