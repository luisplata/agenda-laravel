<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function listCategories(): JsonResponse
    {
        $categories = [
            'Dama',
            'Virtual',
            'Dama Virtual',
            'Trans',
            'Trans Virtual',
            'Caballero de Compañía',
            'Caballero Virtual',
            'Masajista',
        ];

        return response()->json(['categories' => $categories]);
    }
}
