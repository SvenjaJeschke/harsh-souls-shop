<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Size extends Model
{
    protected $fillable = [
        'display_name', 'price', 'product_id', 'operator', 'price_adjustment'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'display_name' => 'string',
        'price' => 'decimal:2',
        'product_id' => 'integer',
        'operator' => 'string',
        'price_adjustment' => 'decimal:2'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
