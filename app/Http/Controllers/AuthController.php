<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->tryCatch(function () use ($request) {
            $data = $request->validated();
            return $this->authService->register($data);
        });
    }

    public function login(LoginRequest $request)
    {
        return $this->tryCatch(function () use ($request) {
            $data = $request->validated();
            return $this->authService->login($data);
        });
    }
}
