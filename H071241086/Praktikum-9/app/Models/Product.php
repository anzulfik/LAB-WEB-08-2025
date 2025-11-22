<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function detail()
    {
        return $this->hasOne(ProductDetail::class, 'product_id');
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class, 'product_warehouse')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}