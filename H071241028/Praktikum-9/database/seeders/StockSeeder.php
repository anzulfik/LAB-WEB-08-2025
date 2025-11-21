<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data produk dan gudang
        if (Product::count() === 0 || Warehouse::count() === 0) {
            $this->command->warn('⚠️ Tidak ada produk atau gudang. Jalankan seeder produk & gudang terlebih dahulu!');
            return;
        }

        // Ambil semua produk dan gudang
        $products = Product::all();
        $warehouses = Warehouse::all();

        // Hapus stok lama (jika ada)
        Stock::truncate();

        // Tambahkan stok acak untuk kombinasi produk & gudang
        foreach ($warehouses as $warehouse) {
            foreach ($products->random(min(5, $products->count())) as $product) {
                Stock::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => rand(5, 100), // jumlah stok acak
                ]);
            }
        }

        $this->command->info('✅ Data stok berhasil ditambahkan!');
    }
}
