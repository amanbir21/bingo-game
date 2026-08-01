<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GamePattern extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'code',
        'description',
        'pattern_data',
        'is_active',
    ];


    protected $casts = [
        'pattern_data' => 'array',
        'is_active' => 'boolean',
    ];



    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    // Pattern has many winners
    public function winners()
    {
        return $this->hasMany(
            Winner::class,
            'pattern_id'
        );
    }



    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */


    public function isActive(): bool
    {
        return $this->is_active === true;
    }


    public function getPatternName()
    {
        return $this->name;
    }
}