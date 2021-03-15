<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebArtisanAuth
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!empty($request->query('key')) && $request->query('key') === \config('app.artisan_key')) {
            return $next($request);
        }
        \abort(404);
    }
}
