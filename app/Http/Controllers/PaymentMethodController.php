<?php
// app/Http/Controllers/PaymentMethodController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Devuelve una lista de métodos de pago.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $paymentMethods = [
            ['name' => 'paypal', 'icon' => 'paypal'],
            ['name' => 'binance', 'icon' => 'binance_icon'],
            ['name' => 'other_bank', 'icon' => 'more_icons_to_bank'],
        ];

        return response()->json($paymentMethods);
    }
}
