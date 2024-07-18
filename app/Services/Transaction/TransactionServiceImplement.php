<?php

namespace App\Services\Transaction;

use App\Constants\TransactionStatus;
use App\Events\TransactionCreated;
use App\Http\Requests\TransactionRequest;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Support\Facades\Log;

class TransactionServiceImplement extends ServiceApi implements TransactionService
{
    /**
     * @param string $title
     */
    protected $title = "transaction";

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(TransactionRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * transaction history implementation
     * @return TransactionService
     */
    public function history(): TransactionService
    {
        try {
            $transactions = $this->mainRepository->all();

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($transactions);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * transaction store implementation
     * @param TransactionRequest $request
     * @param string $type
     * @return TransactionService
     */
    public function store(TransactionRequest $request, string $type): TransactionService
    {
        try {
            $transaction = $this->mainRepository->create([
                'user_id' => $request->user()->id,
                'order_id' => generateOrderId(),
                'amount' => $request->amount,
                'timestamp' => $request->timestamp,
                'type' => $type,
                'status' => TransactionStatus::ON_PROGRESS
            ]);

            // dispatch transaction event
            $message = ucfirst($type) . ' transaction is being processed';
            Log::info($message, ['transaction_id' => $transaction->id]);
            TransactionCreated::dispatch($transaction);

            return $this->setCode(200)
                ->setMessage($message)
                ->setData($transaction);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
