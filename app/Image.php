<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'product_id', 'version_id', 'name', 'storage_url', 'original_name', 'path', 'file_size', 'file_extension', 'is_cover', 'is_visible'
    ];

    public $timestamps = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'version_id' => 'integer',
        'storage_url' => 'string',
        'name' => 'string',
        'original_name' => 'string',
        'path' => 'string',
        'file_size' => 'integer',
        'file_extension' => 'string',
        'is_cover' => 'boolean',
        'is_visible' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class);
    }
}
