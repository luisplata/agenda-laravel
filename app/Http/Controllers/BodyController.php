<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BodyController extends Controller
{
    //
    public function typeOfBody(): JsonResponse
    {
        $typeOfBody = [
            'Delgado/a',
            'Robusto/a',
            'Voluptuoso/a',
            'Curvy',
            'BBW'
        ];

        return response()->json(['typeOfBody' => $typeOfBody]);
    }
}
