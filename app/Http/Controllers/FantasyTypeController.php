<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FantasyTypeController extends Controller
{
    //
    public function fantasyTypeList(): JsonResponse
    {
        $fantasyTypeList = [
            'Juguetes',
            'Disfraces',
            'Lencería',
            'Juego de Roles',
            'Cambio de Roles',
            'Adoración de Pies',
            'Dominación',
            'Sumisa',
            'BDSM',
            'Lluvia Dorada',
            'Fisting',
            'Anal',
            'Squirt',
            'Sadomasoquismo',
            'A consultar'
        ];

        return response()->json(['fantasy_type' => $fantasyTypeList]);
    }
}
