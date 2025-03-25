<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BustController extends Controller
{
    //
    public function bust(): JsonResponse
    {
        $bustList = [
            'Pequeño',
            'Normal',
            'Grande',
            'Gigante'
        ];

        return response()->json(['bust' => $bustList]);
    }
}
