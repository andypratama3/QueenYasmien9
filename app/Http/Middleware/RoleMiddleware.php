<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (!$user->hasAnyRole($roles)) {
            return redirect('/');
        }

        return $next($request);
    }
}
