<?php

declare(strict_types=1);

namespace CzechitasApp\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// phpcs:disable SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    // phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod.Found

    /**
     * Report or log an exception.
     */
    public function report(\Throwable $exception): void
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request $request
     * @return Response|mixed Can return RedirectResponse etc which has not single Laravel ancestor
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function render($request, \Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
