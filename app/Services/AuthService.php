<?php


namespace App\Services;

use App\Repositories\AuthRepositoryInterface;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login($data)
    {
        return $this->authRepository->login($data);
    }
    public function register($data)
    {
        return $this->authRepository->register($data);
    }
}
