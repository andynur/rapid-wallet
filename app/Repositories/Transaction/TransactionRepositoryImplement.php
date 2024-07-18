<?php

namespace App\Repositories\Transaction;

use App\Constants\Caches;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class TransactionRepositoryImplement extends Eloquent implements TransactionRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    /**
     * update transaction status by id
     * @param int $transactionId
     * @param int $status
     * @return void
     */
    public function updateStatus(int $transactionId, int $status): void
    {
        $this->model->where('id', $transactionId)->update(['status' => $status]);
        // Invalidate cache for all transactions
        Cache::forget(Caches::TRANSACTIONS);
    }

    /**
     * store transaction
     * @param array|mixed $data
     * @return Model
     */
    public function store(array $data)
    {
        $transaction = $this->model->create($data);
        // Invalidate cache for all transactions
        Cache::forget(Caches::TRANSACTIONS);
        return $transaction;
    }

    /**
     * get all transaction
     * @param array|mixed $data
     * @return Collection|null
     */
    public function all()
    {
        // Cache for 1 hour
        return Cache::remember(Caches::TRANSACTIONS, Caches::ONE_HOUR_TTL, function () {
            return $this->model->orderBy('id', 'desc')->get();
        });
    }
}
