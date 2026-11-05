<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Support\DamsonAssets;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'sku', 'category', 'unit', 'description', 'cost_price', 'price', 'stock', 'is_active', 'image_path',
    ];

    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Public URL of the product image, or null when none is set. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? DamsonAssets::storage($this->image_path) : null;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
