<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userWallets = auth()->user()->wallets()->get();
        $allWallets = Wallet::whereNotIn('id', $userWallets->pluck('id'))->get()->makeHidden('balance');

        return response()->json([
            'user' => $userWallets,
            'others' => $allWallets,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'balance' => 'required|numeric',
        ]);

        $wallet = auth()->user()->wallets()->create($validatedData);

        return response()->json($wallet, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show($wallet)
    {
        $wallet = auth()->user()->wallets()->findOrFail($wallet);

        return response($wallet, 200);
    }
}
