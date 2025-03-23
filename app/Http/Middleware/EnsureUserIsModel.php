<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsModel
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'Model') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
