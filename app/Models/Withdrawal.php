<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Withdrawal extends Model
{
    use HasFactory;


    protected $fillable = [

        'user_id',
        'wallet_id',
        'payment_method_id',
        'amount',
        'account_name',
        'account_number',
        'status',
        'approved_by',
        'remarks',
        'requested_at',
        'approved_at',

    ];


    protected $casts = [

        'amount' => 'decimal:2',

        'requested_at' => 'datetime',

        'approved_at' => 'datetime',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Withdrawal belongs to player
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Withdrawal belongs to wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }


    // Withdrawal uses payment method
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }


    // Admin who approved/rejected
    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

}