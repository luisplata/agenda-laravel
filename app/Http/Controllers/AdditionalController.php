<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class AdditionalController extends Controller
{
    
    public function listAdditionalServices(): JsonResponse
    {
        $additionalServices = [
            'Eyaculación Cuerpo',
            'Eyaculación Pecho',
            'Eyaculacion Facial',
            'Mujeres y Hombres',
            'Atención a Parejas',
            'Trios M/H/M',
            'Trios H/M/H',
            'Lesbicos',
            'Poses varias',
            'Besos',
            'Bailes'
        ];

        return response()->json(['additional_services' => $additionalServices]);
    }
}
