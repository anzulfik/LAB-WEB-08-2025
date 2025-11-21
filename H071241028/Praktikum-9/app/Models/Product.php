<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category_id'];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke detail produk
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    // Relasi ke stok (menghubungkan produk dan gudang)
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Relasi ke gudang melalui stok
    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'stocks')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    
}
