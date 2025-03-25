<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TailController extends Controller
{
    //
    public function tail(): JsonResponse
    {
        $tailList = [
            'Pequeña',
            'Normal',
            'Grande',
            'Gigante'
        ];

        return response()->json(['tail' => $tailList]);
    }
}
