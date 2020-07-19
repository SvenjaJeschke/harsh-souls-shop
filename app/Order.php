<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'costs', 'comment'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'costs' => 'decimal:2',
        'comment' => 'string'
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return MorphToMany
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'orderable');
    }

    /**
     * @return MorphToMany
     */
    public function versions(): MorphToMany
    {
        return $this->morphedByMany(Version::class, 'orderable');
    }
}
