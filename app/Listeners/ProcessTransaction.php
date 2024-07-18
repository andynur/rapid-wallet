<?php

namespace App\Listeners;

use App\Constants\TransactionTypes;
use App\Events\TransactionCreated;
use App\Models\Transaction;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Wallet\WalletRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessTransaction implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 3;


    /**
     * Create the event listener.
     */
    protected $transactionRepository;
    protected $walletRepository;

    public function __construct(TransactionRepository $transactionRepository, WalletRepository $walletRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void
    {
        $transaction = $event->transaction;

        // prepare http client
        $api_url = env('PAYMENT_API_URL', 'https://yourdomain.com');
        $token = getBearerTokenByUserName($transaction->user->name);
        $payload = $this->payload($transaction);

        $response = Http::timeout(1000)
            ->retry(3, 500)->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->post($api_url, $payload);

        $status = $response->successful() ? 1 : 2;

        DB::transaction(function () use ($transaction, $status) {
            $this->transactionRepository->updateStatus($transaction->id, $status);
            if ($status === 1) {
                if ($transaction->type === TransactionTypes::DEPOSIT) {
                    $this->walletRepository->incrementBalance($transaction->user_id, $transaction->amount);
                    Log::info('Deposit transaction successful', ['transaction_id' => $transaction->id]);
                } else if ($transaction->type === TransactionTypes::WITHDRAWAL) {
                    $this->walletRepository->decrementBalance($transaction->user_id, $transaction->amount);
                    Log::info('Witdraw transaction successful', ['transaction_id' => $transaction->id]);
                }
            } else {
                Log::error('Transaction failed', ['transaction' => $transaction]);
            }
        });
    }

    protected function payload(Transaction $transaction)
    {
        return [
            'order_id' => $transaction->order_id,
            'amount' => $transaction->amount,
            'timestamp' => $transaction->timestamp,
        ];
    }
}
