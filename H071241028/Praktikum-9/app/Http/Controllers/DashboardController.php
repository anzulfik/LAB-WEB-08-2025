<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        // 🔹 Hitung total data utama
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalWarehouses = Warehouse::count();
        $totalStock = Stock::sum('quantity');

        // 🔹 Ambil 5 aktivitas stok terbaru dengan relasi produk & gudang
        $recentActivities = Stock::with(['product', 'warehouse'])
            ->latest()
            ->take(5)
            ->get();

        // 🔹 Hitung stok per kategori untuk grafik (Chart.js)
        $categoryNames = [];
        $categoryStocks = [];

        $categories = Category::with(['products.stocks'])->get();
        foreach ($categories as $category) {
            $categoryNames[] = $category->name;
            $categoryStocks[] = $category->products->sum(function ($product) {
                return $product->stocks->sum('quantity');
            });
        }

        // 🔹 Kirim data ke view
        return view('welcome', compact(
            'totalProducts',
            'totalCategories',
            'totalWarehouses',
            'totalStock',
            'recentActivities',
            'categoryNames',
            'categoryStocks'
        ));
    }
   
public function search(Request $request)
{
    $query = trim($request->input('q'));

    if (!$query) {
        return redirect()->back()->with('error', 'Masukkan kata kunci pencarian.');
    }

    // 🔍 Cari Produk (ikutkan relasi kategori dan gudang melalui stok)
    $products = Product::with(['category', 'stocks.warehouse'])
        ->where('name', 'like', "%{$query}%")
        ->orWhereHas('category', function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        })
        ->orWhere('price', 'like', "%{$query}%")
        ->get();

    // 🔍 Cari Kategori
    $categories = Category::where('name', 'like', "%{$query}%")->get();

    // 🔍 Cari Gudang
    $warehouses = Warehouse::where('name', 'like', "%{$query}%")
        ->orWhere('location', 'like', "%{$query}%")
        ->get();

    // 🔍 Cari Stok (produk di gudang mana dan berapa jumlahnya)
    $stocks = Stock::with(['product.category', 'warehouse'])
        ->whereHas('product', fn($q) => $q->where('name', 'like', "%{$query}%"))
        ->orWhereHas('warehouse', fn($q) => $q->where('name', 'like', "%{$query}%"))
        ->get();

    return view('dashboard.search', compact('query', 'products', 'categories', 'warehouses', 'stocks'));
}
}