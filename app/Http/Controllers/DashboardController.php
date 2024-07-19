<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\Transaction\TransactionService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display the dashboard page.
     */
    public function index(Request $request): Response
    {
        $totalBalance = $request->user()->wallet->balance;
        $transactions = $this->transactionService->history()->getData()->toArray();

        return Inertia::render('Dashboard', [
            'transactions' => $transactions,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Display the deposit form.
     */
    public function deposit(Request $request): Response
    {
        return Inertia::render('Deposit');
    }

    /**
     * Display the withdraw form.
     */
    public function withdraw(Request $request): Response
    {
        return Inertia::render('Withdraw');
    }
}
