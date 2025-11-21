<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::insert([
            ['name' => 'Elektronik', 'description' => 'Produk elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pakaian', 'description' => 'Baju dan aksesoris', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Makanan', 'description' => 'Produk makanan dan minuman', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
