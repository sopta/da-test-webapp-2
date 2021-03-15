<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Auth;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Prologue\Alerts\Facades\Alert;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    public function profileForm(): View
    {
        return \view('auth.profile', [
            'name' => Auth::user()->name,
            'access_token' => Auth::user()->access_token,
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        Auth::user()->update($request->getData());

        Alert::success(\trans('auth.profile.success'))->flash();

        return \back();
    }

    public function regenerateAccessToken(): RedirectResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        $user->access_token = $user->createToken('api')->plainTextToken;
        $user->save();

        Alert::success(\trans('auth.profile.success'))->flash();

        return \back();
    }
}
