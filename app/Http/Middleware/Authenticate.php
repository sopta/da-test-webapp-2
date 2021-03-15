<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param         Request|mixed $request
     * @return        string|mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    protected function redirectTo($request)
    {
        return \route('login');
    }
}
