<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;


    protected $fillable = [

        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',

    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Activity belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    /*
    |--------------------------------------------------------------------------
    | Helper Method
    |--------------------------------------------------------------------------
    */


    public static function createLog(
        $userId,
        $action,
        $description = null
    ) {

        return self::create([

            'user_id' => $userId,

            'action' => $action,

            'description' => $description,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);

    }

}