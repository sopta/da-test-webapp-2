<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Auth;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Models\User;
use CzechitasApp\Rules\EmailRule;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Redirect after user is logged in
     */
    public function redirectTo(): string
    {
        return \route('students.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array<string, mixed> $data
     */
    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => ['required', new EmailRule(), 'unique:users'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'email.unique' => \trans('auth.registration.validation.unique_email'),
            'password.confirmed' => \trans('auth.registration.validation.confirmed_pass'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array<string, mixed> $data
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => substr($data['name'], 0, 6),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user)); // Optional

        return redirect()->route('login')->with('status', 'Account created. Please log in.');
    }
}
