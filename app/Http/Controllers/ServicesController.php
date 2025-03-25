<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    //
    public function listServices(): JsonResponse
    {
        $services = [
            'Presencial',
            'A Domicilio',
            'Virtual',
            'Masajista',
            'Streaptease',
        ];

        return response()->json(['services' => $services]);
    }
}
