<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductWarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_warehouse')->insert([
            [
                'product_id' => 1,
                'warehouse_id' => 1,
                'quantity' => 10,
            ],
            [
                'product_id' => 1,
                'warehouse_id' => 2,
                'quantity' => 5,
            ],
            [
                'product_id' => 2,
                'warehouse_id' => 1,
                'quantity' => 3,
            ],
        ]);
    }
}
