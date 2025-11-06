<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    protected $table = 'fishes';

    protected $fillable = [
        'name', 'rarity', 'base_weight_min', 'base_weight_max',
        'sell_price_per_kg', 'catch_probability', 'description'
    ];

    public function getFormattedPriceAttribute() {
        return number_format($this->sell_price_per_kg, 0, ',', '.').' Coins/kg';
    }

    public function getFormattedWeightRangeAttribute() {
        return "{$this->base_weight_min} - {$this->base_weight_max} kg";
    }

    public function scopeRarity($query, $rarity) {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }
}
