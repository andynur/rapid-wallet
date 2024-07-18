<?php

namespace App\Http\Controllers;

use App\Constants\TransactionTypes;
use App\Http\Requests\TransactionRequest;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\Request;

/**
 * @group Transaction Management
 *
 * APIs for managing transactions
 */
class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Deposit Money
     *
     * @authenticated
     * @param TransactionRequest $request
     * @response 200 {
     *  "code": 200,
     *  "message": "Deposit transaction is being processed",
     *  "data": null
     * }
     * @response 422 {
     *  "message": "... field is required.",
     *  "errors": {},
     * }
     */
    public function deposit(TransactionRequest $request)
    {
        return $this->transactionService->store($request, TransactionTypes::DEPOSIT)->toJson();
    }

    /**
     * Withdraw Money
     *
     * @authenticated
     * @param TransactionRequest $request
     * @response 200 {
     *  "code": 200,
     *  "message": "Withdrawal transaction is being processed",
     *  "data": null
     * }
     * @response 422 {
     *  "message": "... field is required.",
     *  "errors": {},
     * }
     */
    public function withdraw(TransactionRequest $request)
    {
        return $this->transactionService->store($request, TransactionTypes::WITHDRAWAL)->toJson();
    }

    /**
     * Get transaction history
     *
     * Returns the transaction history for the authenticated user.
     *
     * @authenticated
     * @response 200 {
     *  "code": 200,
     *  "message": "OK",
     *  "data": [
     *      {
     *          "id": 1,
     *          "user_id": 1,
     *          "order_id": "12345",
     *          "amount": 5000.00,
     *          "timestamp": "2024-07-01 12:00:00",
     *          "type": "deposit",
     *          "status": 1,
     *          "created_at": "2024-07-01 12:00:00",
     *          "updated_at": "2024-07-01 12:00:00"
     *      }
     *  ]
     * }
     */
    public function history(Request $request)
    {
        return $this->transactionService->history()->toJson();
    }
}
