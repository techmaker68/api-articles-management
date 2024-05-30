<?php

namespace App\Repositories;

interface AuthRepositoryInterface
{
    public function login(array $data);
    public function register(array $data);
}
