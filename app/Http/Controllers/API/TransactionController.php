<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Handle transferring fund
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(Request $request)
    {
        $validatedData = $request->validate([
            'from' => 'required|exists:wallets,id',
            'to' => 'required|exists:wallets,id',
            'amount' => 'required|numeric'
        ]);

        // Create an instance of transaction and filled it
        $commission = $validatedData['amount'] * Transaction::COMMISSION;
        $transaction = Transaction::create([
            'amount' => $validatedData['amount'],
            'commission' => $commission,
        ]);

        // Update wallets
        $fromWallet = auth()->user()->wallets()->findOrFail($validatedData['from']);
        $toWallet = Wallet::whereNotIn('id', [$fromWallet->id])->findOrFail($validatedData['to']);
        $fromWallet->balance -= $validatedData['amount'];
        $toWallet->balance += ($validatedData['amount'] - $commission);
        $fromWallet->save();
        $toWallet->save();

        // Associate transaction with source and destination wallets
        $transaction->walletFrom()->associate($fromWallet);
        $transaction->walletTo()->associate($toWallet);
        $transaction->save();

        // Hide some data in response
        $transaction->walletTo->makeHidden('balance');

        return response()->json($transaction, 200);
    }

    /**
     * Display a listing of the transaction from a wallet
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function transactions()
    {
        $transactionsFrom = auth()->user()->transactionsFrom()->orderBy('created_at', 'desc')->get();
        $transactionsTo = auth()->user()->transactionsTo()->orderBy('created_at', 'desc')->get();
        return response()->json([
            'send' => $transactionsFrom,
            'receive' => $transactionsTo,
        ], 200);
    }
}
