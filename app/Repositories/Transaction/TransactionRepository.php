<?php

namespace App\Repositories\Transaction;

use LaravelEasyRepository\Repository;

interface TransactionRepository extends Repository
{
    public function updateStatus(int $transactionId, int $status): void;
}
