<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = env('API_ACCESS_TOKEN', '123456');
        $header = $request->header('Authorization');

        if (!$header || $header !== 'Bearer ' . $token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
