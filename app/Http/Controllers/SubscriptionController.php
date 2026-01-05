<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Crear una suscripción para un usuario
     */
    public function store(Request $request, $userId)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'months' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($userId);

        if (!$user || $user->role !== 'Model') {
            return response()->json(['error' => 'Usuario no válido'], 404);
        }

        $person = Person::where('user_id', $user->id)->first();

        if (!$person) {
            return response()->json(['error' => 'No se encontró una persona asociada'], 404);
        }

        // Buscar suscripción actual
        $subscription = Subscription::where('user_id', $user->id)->latest()->first();
        $now = Carbon::now();

        if ($subscription && $subscription->status === 1) {
            // Si está activa, extender fecha
            $newExpiration = Carbon::parse($subscription->expires_at)->addMonths($request->months);
        } else {
            // Si no está activa, empezar desde hoy
            $newExpiration = $now->addMonths($request->months);
        }

        // Crear o actualizar la suscripción
        $subscription = Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'expires_at' => $newExpiration,
                'status' => 1, // Activa
            ]
        );

        // Hacer visible la persona
        $person->update(['is_visible' => true]);

        return response()->json([
            'message' => 'Suscripción creada o extendida correctamente',
            'subscription' => $subscription->only(['expires_at']),
        ], 201);
    }

    public function checkSubscriptions()
    {
        $today = now();

        // Buscar suscripciones activas
        $subscriptions = Subscription::where('status', 1)->get();

        $updated = 0;

        foreach ($subscriptions as $subscription) {
            if ($subscription->expires_at < $today) {
                // Marcar como suspendida por pago
                $subscription->update(['status' => 3]);

                // Ocultar la persona ligada a la suscripción
                $person = Person::where('user_id', $subscription->user_id)->first();
                if ($person) {
                    $person->update(['is_visible' => false]);
                }

                $updated++;
            }
        }

        return response()->json([
            'message' => 'Verificación completada',
            'subscriptions_checked' => count($subscriptions),
            'subscriptions_updated' => $updated,
        ]);
    }

}
