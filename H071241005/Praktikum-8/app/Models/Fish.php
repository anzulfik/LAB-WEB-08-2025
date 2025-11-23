<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Fish extends Model
{
    use HasFactory;

    /**
     * SECARA PAKSA MENENTUKAN NAMA TABEL YANG BENAR
     * Ini untuk mengatasi masalah cache yang bandel.
     */
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

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['rarity'] ?? false, function ($query, $rarity) {
            return $query->where('rarity', $rarity);
        });

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->sell_price_per_kg, 0, ',', '.') . ' Coins/kg';
    }

    public function getFormattedWeightRangeAttribute(): string
    {
        return $this->base_weight_min . 'kg - ' . $this->base_weight_max . 'kg';
    }
}