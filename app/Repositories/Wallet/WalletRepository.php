<?php

namespace App\Repositories\Wallet;

use LaravelEasyRepository\Repository;

interface WalletRepository extends Repository
{
    public function incrementBalance(int $userId, float $amount): void;
    public function decrementBalance(int $userId, float $amount): void;
}
