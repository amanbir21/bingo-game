<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;


    protected $fillable = [

        'key',
        'value',
        'description',

    ];


    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    // Get setting value by key
    public static function getValue($key, $default = null)
    {
        return self::where('key', $key)
            ->value('value') ?? $default;
    }


    // Update or create setting
    public static function setValue($key, $value, $description = null)
    {
        return self::updateOrCreate(
            [
                'key' => $key
            ],
            [
                'value' => $value,
                'description' => $description,
            ]
        );
    }

}