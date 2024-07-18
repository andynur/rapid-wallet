<?php

namespace App\Services\Transaction;

use App\Http\Requests\TransactionRequest;
use LaravelEasyRepository\BaseService;

interface TransactionService extends BaseService
{
    public function store(TransactionRequest $request, string $type): TransactionService;
    public function history(): TransactionService;
}
