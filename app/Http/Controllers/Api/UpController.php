<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Controllers\Api;

use CzechitasApp\Http\Controllers\Controller;
use CzechitasApp\Services\Models\UserService;
use Symfony\Component\HttpFoundation\Response;

final class UpController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): Response
    {
        $user = $this->userService->getUserByEmail('da-app.master@czechitas.cz');
        return \response()->json($user);
    }
}
