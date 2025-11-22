<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $p1 = Product::create([
            'name' => 'Laptop ASUS',
            'price' => 15000000,
            'category_id' => 1,
        ]);

        $p1->detail()->create([
            'description' => 'Laptop ASUS 15 inch untuk kerja',
            'weight' => 1.50,
            'size' => '15 inch',
        ]);

        // Produk 2
        $p2 = Product::create([
            'name' => 'Kursi Kayu',
            'price' => 450000,
            'category_id' => 2,
        ]);

        $p2->detail()->create([
            'description' => 'Kursi kayu jati minimalis',
            'weight' => 5.20,
            'size' => 'Medium',
        ]);
    }
}
