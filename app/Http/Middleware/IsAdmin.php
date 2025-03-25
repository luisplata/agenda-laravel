<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();
        if(!$user || $user->role !== 'Admin'){
            return response()->json(['message' => "No autorizado is'nt a Admin"], 403);
        }
        return $next($request);
    }
}
