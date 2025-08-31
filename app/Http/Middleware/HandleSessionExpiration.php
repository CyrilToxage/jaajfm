<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur n'est pas connecté et que la requête nécessite une authentification
        if (!Auth::check() && $request->expectsJson()) {
            return response()->json([
                'error' => 'Session expirée',
                'redirect' => route('login')
            ], 401);
        }

        return $next($request);
    }
}
