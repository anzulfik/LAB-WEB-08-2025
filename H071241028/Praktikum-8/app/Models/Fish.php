<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Fish extends Model
{
    protected $table = 'fishes';

     protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'catch_probability' => 'decimal:2',
        'sell_price_per_kg' => 'integer',
    ];
    // Accessor: formatted price
    public function getFormattedPriceAttribute(): string
    {
        return 'Coins ' . number_format($this->sell_price_per_kg, 0, ',', '.');
    }

    // Accessor: formatted weight range
    public function getWeightRangeAttribute(): string
    {
        return number_format($this->base_weight_min, 2, ',', '.') . ' kg - ' .
               number_format($this->base_weight_max, 2, ',', '.') . ' kg';
    }

    // Scope: filter rarity
    public function scopeRarity(Builder $query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }


    // Scope: search name
    public function scopeSearch(Builder $query, $term)
    {
        if ($term) {
            return $query->where('name', 'LIKE', "%{$term}%");
        }
        return $query;
    }
}
