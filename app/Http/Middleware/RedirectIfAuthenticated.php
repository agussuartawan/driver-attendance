<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $role = $user->getRoleNames()->first();

                return match ($role) {
                    'driver'   => redirect()->route('mobile.attendance'),
                    'admin'    => redirect()->route('dashboard'),
                    'manager'  => redirect()->route('dashboard'),
                    default    => redirect()->route('dashboard'),
                };
            }
        }

        return $next($request);
    }
}
