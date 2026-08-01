<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletTransaction extends Model
{
    use HasFactory;


    protected $fillable = [

        'wallet_id',
        'user_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference',
        'description',
        'status',

    ];


    protected $casts = [

        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /*
    |--------------------------------------------------------------------------
    | Create Transaction
    |--------------------------------------------------------------------------
    */


    public static function createTransaction(
        $wallet,
        $type,
        $amount,
        $description = null
    ) {

        $before = $wallet->balance;


        if(in_array($type, [
            'withdraw',
            'ticket_purchase'
        ])) {

            if($before < $amount){

                throw new \Exception(
                    'Insufficient wallet balance'
                );

            }


            $after = $before - $amount;


        } else {


            $after = $before + $amount;

        }



        // Update wallet balance

        $wallet->update([

            'balance' => $after

        ]);



        // Save transaction

        return self::create([

            'wallet_id' => $wallet->id,

            'user_id' => $wallet->user_id,

            'type' => $type,

            'amount' => $amount,

            'balance_before' => $before,

            'balance_after' => $after,

            'reference' => strtoupper(
                uniqid('TXN-')
            ),

            'description' => $description,

            'status' => 'completed',

        ]);

    }

}