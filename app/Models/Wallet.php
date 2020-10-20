<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'balance',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the transactions for the wallet as source of transaction.
     */
    public function transactionsFrom()
    {
        return $this->hasMany('App\Models\Transaction', 'from_wallet_id');
    }

    /**
     * Get the transactions for the wallet as destination of transaction.
     */
    public function transactionsTo()
    {
        return $this->hasMany('App\Models\Transaction', 'to_wallet_id');
    }
}
