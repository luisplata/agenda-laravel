<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeOfMassageController extends Controller
{
    //
    public function typeOfMassageList(): JsonResponse
    {
        $typeOfMassageList = [
            'Convencional',
            'Erotico',
            'Relajante',
            'Sensitivo',
            'Tántrico',
            'Estimulante',
            'Prostático',
            'Antiestres'
        ];

        return response()->json(['type_of_massage' => $typeOfMassageList]);
    }
}
