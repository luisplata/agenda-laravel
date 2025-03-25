<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BioTypeController extends Controller
{
    //
    public function bioTypeList(): JsonResponse
    {
        $bioTypeList = [
            'Natural',
            'Operado/a'
        ];

        return response()->json(['biotype' => $bioTypeList]);
    }
}
