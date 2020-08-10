<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'display_name', 'description', 'price', 'is_active', 'color_code'
    ];

    public $timestamps = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'display_name' => 'string',
        'description' => 'string',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'color_code' => 'string'
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * @return BelongsToMany
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class);
    }

    /**
     * @return HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }

    /**
     * @return MorphToMany
     */
    public function orders(): MorphToMany
    {
        return $this->morphToMany(Order::class, 'orderable');
    }

    /**
     * @return HasOne
     */
    public function discount(): HasOne
    {
        return $this->hasOne(Discount::class);
    }

    /**
     * @return HasMany
     */
    public function sizes(): HasMany
    {
        return $this->hasMany(Size::class);
    }

    /**
     * @return HasOne
     */
    public function coverImage(): HasOne
    {
        return $this->hasOne(Image::class)->where('is_cover', '=', true);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public static function scopeDiscountProducts(Builder $query): Builder
    {
        return $query->whereHas('discount');
    }
}
