<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keyword extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
