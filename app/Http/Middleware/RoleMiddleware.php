<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(401, 'You are not authorized to access this resource.');
        }

        if (!auth()->user()->roles()->where('name', $role)->exists()) {
            abort(403, "You don't have enough permission to access this resource");
        }
        return $next($request);
    }
}
