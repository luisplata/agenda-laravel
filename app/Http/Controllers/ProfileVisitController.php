<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProfileVisit;

class ProfileVisitController extends Controller
{
    /**
     * Registrar una visita a un perfil.
     */
    public function store(Request $request)
    {
        // Verificar si el perfil realmente existe en la base de datos
        $user = auth('api')->user();
        $profile = User::find($user->id);

        if (!$profile) {
            return response()->json(['message' => 'El perfil no existe'], 404);
        }

        ProfileVisit::create([
            'profile_id' => $profile->id,
        ]);

        return response()->json(['message' => 'Visita registrada con éxito'], 201);
    }


    /**
     * Obtener visitas en los últimos 7 días
     */
    public function last7Days()
    {
        $user = auth('api')->user();
        return response()->json(ProfileVisit::getVisitsByRange('7 DAY', $user->id));
    }

    /**
     * Obtener visitas en el último mes
     */
    public function lastMonth()
    {
        $user = auth('api')->user();
        return response()->json(ProfileVisit::getVisitsByRange('1 MONTH', $user->id));
    }

    /**
     * Obtener visitas en los últimos 3 meses
     */
    public function last3Months()
    {
        $user = auth('api')->user();
        return response()->json(ProfileVisit::getVisitsByRange('3 MONTH', $user->id));
    }

}
