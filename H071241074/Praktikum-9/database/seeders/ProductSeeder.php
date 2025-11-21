<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductDetail;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Laptop XYZ',
                'price' => 15000000,
                'category_id' => 1,
                'detail' => [
                    'description' => 'Laptop terbaru dengan RAM 16GB',
                    'weight' => 2.0,
                    'size' => '15 inch',
                ],
            ],
            [
                'name' => 'Kaos Polos',
                'price' => 80000,
                'category_id' => 2,
                'detail' => [
                    'description' => 'Kaos katun nyaman dipakai',
                    'weight' => 0.2,
                    'size' => 'L',
                ],
            ],
        ];

        foreach($products as $p){
            $product = Product::create([
                'name' => $p['name'],
                'price' => $p['price'],
                'category_id' => $p['category_id'],
            ]);

            ProductDetail::create([
                'product_id' => $product->id,
                'description' => $p['detail']['description'],
                'weight' => $p['detail']['weight'],
                'size' => $p['detail']['size'],
            ]);
        }
    }
}
