<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Elektronik',
            'description' => 'Semua barang elektronik',
        ]);

        Category::create([
            'name' => 'Furniture',
            'description' => 'Peralatan rumah tangga',
        ]);

        Category::create([
            'name' => 'Fashion',
            'description' => 'Pakaian dan aksesoris',
        ]);
    }
}
