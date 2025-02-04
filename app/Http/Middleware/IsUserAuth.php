<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->input('token');
        if (!$token) {
            return response()->json(['message' => 'No autorizado porque no encontro el token'], 401);
        }
        try {
            auth()->setToken($token);

            if (!auth()->check()) {
                return response()->json(['message' => 'No autorizado porque el token no es valido'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'No autorizado porque el token no es valido'], 401);
        }
        return $next($request);
    }
}
