<?php

namespace App\Repositories\Wallet;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Wallet;

class WalletRepositoryImplement extends Eloquent implements WalletRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }

    /**
     * increment wallet balance
     * @param int $userId
     * @param float $amount
     * @return void
     */
    public function incrementBalance(int $userId, float $amount): void
    {
        $wallet = $this->model->where('user_id', $userId)->first();
        $wallet->increment('balance', $amount);
    }

    /**
     * decrement wallet balance
     * @param int $userId
     * @param float $amount
     * @return void
     */
    public function decrementBalance(int $userId, float $amount): void
    {
        $wallet = $this->model->where('user_id', $userId)->first();
        $wallet->decrement('balance', $amount);
    }
}
