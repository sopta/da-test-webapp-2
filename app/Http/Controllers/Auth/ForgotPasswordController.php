<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Auth;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Services\BreadcrumbService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Route;

class ForgotPasswordController extends Controller
{
    /**
     *--------------------------------------------------------------------------
     * Password Reset Controller
     *--------------------------------------------------------------------------
     *
     * This controller is responsible for handling password reset emails and
     * includes a trait which assists in sending these notifications from
     * your application to your users. Feel free to explore this trait.
     */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BreadcrumbService $breadcrumbService)
    {
        $this->middleware('guest');

        $breadcrumbService
            ->addLevel('login', \trans('auth.login.title'))
            ->addLevel(Route::currentRouteName(), \trans('auth.forget.title'));
    }
}
