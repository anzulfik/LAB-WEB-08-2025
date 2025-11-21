<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        Warehouse::insert([
            ['name' => 'Gudang Jakarta', 'location' => 'Jakarta Selatan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gudang Bandung', 'location' => 'Bandung Barat', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
