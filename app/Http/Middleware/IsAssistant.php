<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAssistant
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if (!$user || $user->role !== 'Assistant') {
            return response()->json(['message' => 'No autorizado isnt a model'], 403); // Error 403 para usuario sin permisos
        }

        return $next($request);
    }
}
