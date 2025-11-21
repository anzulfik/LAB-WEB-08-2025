<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        // Query produk beserta relasi kategori & detail
        $query = Product::with(['category', 'detail'])->latest();

        // Jika ada filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Ambil hasil paginasi
        $products = $query->paginate(10);

        // Kirim data ke view
        return view('products.index', compact('products', 'categories'));
    }

    // Form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable |string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan product
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            // Simpan product detail
            $product->detail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Tampilkan detail produk
    public function show(Product $product)
    {
        $product->load(['category', 'detail']);
        return view('products.show', compact('product'));
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('detail');
        return view('products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $product) {
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);

            $product->detail()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'description' => $request->description,
                    'weight' => $request->weight,
                    'size' => $request->size,
                ]
            );
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk (otomatis hapus detail karena cascade)
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
