<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Specify commission on each transaction
     */
    public const COMMISSION = 1.5 / 100;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'commission',
    ];

    /**
     * Get the wallet that owns the source of transaction.
     */
    public function walletFrom()
    {
        return $this->belongsTo('App\Models\Wallet', 'from_wallet_id');
    }

    /**
     * Get the wallet that owns the destination of transaction.
     */
    public function walletTo()
    {
        return $this->belongsTo('App\Models\Wallet', 'to_wallet_id');
    }
}
