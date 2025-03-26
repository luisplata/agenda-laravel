<?php

namespace App\Http\Controllers;

use App\Models\Person;
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
        $user = auth('api')->user();
        $person = Person::where('user_id', $user->id)->first();

        if (!$person) {
            return response()->json(['message' => 'No tienes un perfil válido para registrar visitas'], 403);
        }

        ProfileVisit::create([
            'profile_id' => $person->id,
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
