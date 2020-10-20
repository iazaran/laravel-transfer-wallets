<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the wallets for the user.
     */
    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet');
    }

    /**
     * Get the transactions for the user as a source.
     */
    public function transactionsFrom()
    {
        return $this->hasManyThrough(
            'App\Models\Transaction',
            'App\Models\Wallet',
            'user_id',
            'from_wallet_id',
        );
    }

    /**
     * Get the transactions for the user as a destination.
     */
    public function transactionsTo()
    {
        return $this->hasManyThrough(
            'App\Models\Transaction',
            'App\Models\Wallet',
            'user_id',
            'to_wallet_id',
        );
    }
}
