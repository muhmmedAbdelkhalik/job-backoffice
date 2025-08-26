<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;
            $hasAccess = in_array($userRole, $allowedRoles);
            if (!$hasAccess) {
                abort(403);
            }
        }

        return $next($request);
    }
}
