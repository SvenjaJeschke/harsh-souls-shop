<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'age', 'phone_number', 'street', 'city'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'age' => 'integer',
        'phone_number' => 'string',
        'street' => 'string',
        'city' => 'string'
    ];

    /**
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
