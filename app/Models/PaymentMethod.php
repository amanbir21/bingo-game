<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;


    protected $fillable = [

        'name',
        'provider',
        'logo',
        'is_active',

    ];


    protected $casts = [

        'is_active' => 'boolean',

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Payment method has many payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    // Payment method has many withdrawals
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

}