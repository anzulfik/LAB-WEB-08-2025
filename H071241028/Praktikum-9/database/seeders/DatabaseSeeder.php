<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Stock;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🧑‍💻 Tambahkan 1 user admin
        User::factory()->create([
            'name' => 'Admin Laravel',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // login: admin@example.com / password
        ]);

        // 📦 Tambahkan kategori
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik rumah & kantor'],
            ['name' => 'Furnitur', 'description' => 'Meja, kursi, dan perlengkapan rumah'],
            ['name' => 'Pakaian', 'description' => 'Busana pria, wanita, dan anak'],
            ['name' => 'Peralatan Kantor', 'description' => 'Printer, kertas, alat tulis, dan lainnya'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 🏭 Tambahkan gudang
        $warehouses = [
            ['name' => 'Gudang Makassar', 'location' => 'Jl. Perintis Kemerdekaan No. 45, Makassar'],
            ['name' => 'Gudang Gowa', 'location' => 'Jl. Sultan Hasanuddin No. 12, Gowa'],
            ['name' => 'Gudang Sengkang', 'location' => 'Jl. Veteran No. 99, Wajo'],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::create($wh);
        }

        // 🛒 Tambahkan produk
        $products = [
            ['name' => 'Laptop ASUS VivoBook', 'price' => 9500000, 'category_id' => 1],
            ['name' => 'Printer Canon Pixma', 'price' => 1500000, 'category_id' => 4],
            ['name' => 'Kursi Kantor Ergonomis', 'price' => 750000, 'category_id' => 2],
            ['name' => 'Kaos Polos Cotton', 'price' => 120000, 'category_id' => 3],
            ['name' => 'Meja Belajar Kayu', 'price' => 850000, 'category_id' => 2],
            ['name' => 'Monitor LG 24"', 'price' => 2100000, 'category_id' => 1],
            ['name' => 'Headset Logitech G331', 'price' => 950000, 'category_id' => 1],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // 📊 Tambahkan stok untuk setiap produk di setiap gudang
        foreach (Warehouse::all() as $warehouse) {
            foreach (Product::inRandomOrder()->take(5)->get() as $product) {
                Stock::create([
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'quantity' => rand(10, 100),
                ]);
            }
        }

        $this->command->info('✅ Database berhasil diisi dengan data awal lengkap!');
    }
}
