<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ?string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->isRoleParent()) {
                return \redirect()->route('students.index');
            }

            return \redirect()->route('home');
        }

        return $next($request);
    }
}
