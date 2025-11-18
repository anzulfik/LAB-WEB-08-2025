<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
    ];

    // N:M dengan Product
    public function products()
    {
        // Tentukan nama tabel pivot dan ambil 'quantity' 
        return $this->belongsToMany(Product::class, 'products_warehouses')->withPivot('quantity');
    }
}