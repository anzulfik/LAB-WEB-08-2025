<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    // Relasi ke stok (1 gudang memiliki banyak stok)
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Relasi ke produk melalui tabel stocks
    public function products()
    {
        return $this->belongsToMany(Product::class, 'stocks')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
