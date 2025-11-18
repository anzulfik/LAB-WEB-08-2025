<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fish extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'fishes';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'rarity',
        'base_weight_min',
        'base_weight_max',
        'sell_price_per_kg',
        'catch_probability',
        'description',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'base_weight_min' => 'decimal:2',
        'base_weight_max' => 'decimal:2',
        'sell_price_per_kg' => 'integer',
        'catch_probability' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Validation rules for creating/updating fish
     */
    public static function validationRules($fishId = null)
    {
        return [
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:1',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom validation messages
     */
    public static function validationMessages()
    {
        return [
            'name.required' => 'Nama ikan harus diisi.',
            'name.max' => 'Nama ikan tidak boleh lebih dari 100 karakter.',
            'rarity.required' => 'Rarity Ikan Harus Diisi.',
            'rarity.in' => 'Rarity Ikan Tidak Valid.',
            'base_weight_min.required' => 'Berat minimum ikan harus diisi.',
            'base_weight_min.min' => 'Berat minimum ikan minimal 0.01 kg',
            'base_weight_max.required' => 'Berat maksimum ikan harus diisi.',
            'base_weight_max.gt' => 'Berat maksimum ikan harus lebih besar dari berat minimum.',
            'sell_price_per_kg.required' => 'Harga jual ikan harus diisi.',
            'sell_price_per_kg.min' => 'Harga jual ikan minimal 1 Coin.',
            'catch_probability.required' => 'Probabilitas ikan ditangkap harus diisi.',
            'catch_probability.min' => 'Probabilitas ikan ditangkap minimal 0.01%',
            'catch_probability.max' => 'Probabilitas ikan ditangkap maksimal 100%',
        ];
    }

    /**
     * Scope for filtering by rarity
     */
    public function scopeByRarity($query, $rarity)
    {
        if ($rarity) {
            return $query->where('rarity', $rarity);
        }
        return $query;
    }

    /**
     * Scope for searching by name
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Accessor: Get formatted sell price
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->sell_price_per_kg) . ' Coins';
    }

    /**
     * Accessor: Get formatted weight range
     */
    public function getWeightRangeAttribute()
    {
        return $this->base_weight_min . ' - ' . $this->base_weight_max . ' kg';
    }

    /**
     * Accessor: Get maximum potential sell value
     */
    public function getMaxSellValueAttribute()
    {
        return $this->base_weight_max * $this->sell_price_per_kg;
    }

    /**
     * Accessor: Get formatted max sell value
     */
    public function getFormattedMaxSellValueAttribute()
    {
        return number_format($this->max_sell_value) . ' Coins';
    }

    /**
     * Get rarity color class for badges
     */
    public function getRarityColorAttribute()
    {
        $colors = [
            'Common' => 'secondary',
            'Uncommon' => 'success',
            'Rare' => 'primary',
            'Epic' => 'purple',
            'Legendary' => 'warning',
            'Mythic' => 'danger',
            'Secret' => 'gradient',
        ];

        return $colors[$this->rarity] ?? 'secondary';
    }
}