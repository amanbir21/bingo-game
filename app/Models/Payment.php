<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [

        'user_id',
        'wallet_id',
        'payment_method_id',
        'amount',
        'currency',
        'transaction_reference',
        'provider_reference',
        'status',
        'paid_at',

    ];


    protected $casts = [

        'amount' => 'decimal:2',
        'paid_at' => 'datetime',

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Payment belongs to a wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }


    // Payment belongs to a payment method
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}