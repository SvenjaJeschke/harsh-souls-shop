<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Version extends Model
{
    protected $fillable = [
        'product_id', 'display_name', 'color', 'color_code', 'price', 'is_active', 'operator', 'price_adjustment'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'display_name' => 'string',
        'color' => 'string',
        'color_code' => 'string',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'operator' => 'string',
        'price_adjustment' => 'decimal:2'
    ];

    /**
     * @return MorphToMany
     */
    public function orders(): MorphToMany
    {
        return $this->morphToMany(Order::class, 'orderable');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(Image::class);
    }
}
