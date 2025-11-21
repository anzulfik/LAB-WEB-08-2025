<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    // Nama tabel (default-nya Laravel akan otomatis pakai 'stocks', jadi ini opsional)
    protected $table = 'stocks';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity',
    ];

    // Relasi ke tabel produk (banyak stok dimiliki oleh satu produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke tabel gudang (banyak stok dimiliki oleh satu gudang)
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // Accessor opsional: format jumlah stok dengan pemisah ribuan
    public function getFormattedQuantityAttribute()
    {
        return number_format($this->quantity, 0, ',', '.');
    }

    // Scope opsional: untuk mempermudah filter
    public function scopeByWarehouse($query, $warehouseId)
    {
        return $query->where('warehouse_id', $warehouseId);
    }

    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }
}
