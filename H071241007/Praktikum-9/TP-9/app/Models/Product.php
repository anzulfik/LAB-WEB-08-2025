<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    //1:N dengan category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //1:1 dengan produk Detail
    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    //N:M dengan Warehouse
    public function warehouses()
    { 
    return $this->belongsToMany(Warehouse::class, 'products_warehouses')->withPivot('quantity');
    }

    //helper untuk total stock disebuah gudang
    public function getTotalStockAttribute()
    {
        return $this->warehouses()->sum('quantity');
    }
}