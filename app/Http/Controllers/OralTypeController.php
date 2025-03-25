<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OralTypeController extends Controller
{
    //
    public function oralTypeList(): JsonResponse
    {
        $oralTypeList = [
            'Al Natural',
            'Con Protección',
            'Garganta profunda',
            '69'
        ];

        return response()->json(['oral_type' => $oralTypeList]);
    }
}
