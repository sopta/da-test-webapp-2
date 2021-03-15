<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Auth;

use CzechitasApp\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    /*
     *--------------------------------------------------------------------------
     * Confirm Password Controller
     *--------------------------------------------------------------------------
     *
     * This controller is responsible for handling password confirmations and
     * uses a simple trait to include the behavior. You're free to explore
     * this trait and override any functions that require customization.
     *
     */
    use ConfirmsPasswords;

    /**
     * Redirect after user is logged in
     */
    public function redirectTo(): string
    {
        $user = Auth::user();
        if ($user->isRoleParent()) {
            return \route('students.index');
        }

        return \route('home');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return        array<string, string>
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    protected function validationErrorMessages()
    {
        return [
            'password' => \trans('auth.confirm.bad_password'),
        ];
    }
}
