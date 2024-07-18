<?php

namespace App\Services\User;

use LaravelEasyRepository\BaseService;

interface UserService extends BaseService
{
    public function register(array $data): UserService;
    public function login(array $credentials): UserService;
}
