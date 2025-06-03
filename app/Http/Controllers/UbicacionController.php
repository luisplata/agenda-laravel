<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UbicacionController extends Controller
{
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'ciudad' => 'nullable|string|max:255',
            'user_id' => 'required|integer',
        ]);

        // Usa el usuario autenticado, ignora el user_id recibido
        $validated['user_id'] = auth()->id();

        $ubicacion = Ubicacion::create($validated);

        return response()->json([
            'message' => 'Ubicación guardada correctamente.',
            'ubicacion' => $ubicacion
        ], 201);
    }

    public function ultimaUbicacion()
    {
        $ultima = Ubicacion::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$ultima) {
            return response()->json(['message' => 'No hay ubicaciones registradas.'], 404);
        }

        return response()->json($ultima);
    }

    public function usuariosCerca(Request $request)
    {
        $lat = $request->input('latitud');
        $lon = $request->input('longitud');
        $km = $request->input('kilometros');

        if (!$lat || !$lon || !$km) {
            return response()->json(['error' => 'Faltan parámetros latitud, longitud o kilometros'], 400);
        }

        // Obtener la última ubicación por usuario (mayor id)
        $subquery = Ubicacion::select('user_id', 'latitud', 'longitud')
            ->whereRaw('id = (SELECT MAX(id) FROM ubicacions as u2 WHERE u2.user_id = ubicacions.user_id)');

        $rawQuery = $subquery->toSql();

        $results = DB::table(DB::raw("({$rawQuery}) as ult_ubic"))
            ->mergeBindings($subquery->getQuery())
            ->select('user_id', 'latitud', 'longitud', DB::raw("(
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitud)) *
                    cos(radians(longitud) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitud))
                )
            ) AS distancia"))
            ->having('distancia', '<=', $km)
            ->orderBy('distancia', 'asc')
            ->setBindings([$lat, $lon, $lat])
            ->get();

        //load all user data
        $results = $results->map(function ($ubicacion) {
            $user = User::find($ubicacion->user_id);
            if ($user) {
                $ubicacion->user = $user;
            } else {
                $ubicacion->user = null; // O manejar el caso donde no se encuentra el usuario
            }
            return $ubicacion;
        });

        return response()->json($results);
    }
}
