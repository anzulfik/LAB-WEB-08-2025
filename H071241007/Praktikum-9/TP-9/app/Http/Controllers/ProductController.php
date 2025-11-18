<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Kita butuh ini untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Kita butuh ini untuk Database Transaction

class ProductController extends Controller
{
    /**
     * Menampilkan list produk (nama, kategori, harga) 
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form inputan (nama, dropdown kategori, harga,
     * dan semua atribut dari produk detail) 
     */
    public function create()
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $categories = Category::orderBy('name')->get();
        
        return view('products.create', compact('categories'));
    }

    /**
     * Menyimpan data dari form create
     */
    public function store(Request $request)
    {
        // 1. Validasi semua input (dari 2 tabel) 
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id', // 'exists' memastikan ID-nya ada di tabel categories
            'price' => 'required|numeric|min:0',
            
            // Atribut ProductDetail 
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255|min:0',
        ]);

        // 2. Gunakan Database Transaction
        // Ini memastikan jika salah satu query gagal (misal simpan detail gagal),
        // maka query simpan produk juga akan dibatalkan (rollback).
        try {
            DB::beginTransaction();

            // 3. Simpan ke tabel 'products'
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
            ]);

            // 4. Simpan ke tabel 'product_details' menggunakan relasi
            $product->productDetail()->create([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
                // 'product_id' akan otomatis terisi oleh relasi
            ]);

            // 5. Jika semua berhasil, commit transaksi
            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');

        } catch (\Exception $e) {
            // 6. Jika terjadi error, batalkan semua
            DB::rollBack();
            // Tampilkan pesan error
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Menampilkan seluruh data mengenai produk 
     */
    public function show(Product $product)
    {
        // Load relasi 'category' dan 'productDetail'
        $product->load('category', 'productDetail');
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit (sama seperti create, tapi ada data) 
     */
    public function edit(Product $product)
    {
        // Kita butuh data produk beserta detailnya
        $product->load('productDetail');
        
        // Kita juga butuh list kategori untuk dropdown
        $categories = Category::orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Menyimpan data dari form edit
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
        ]);

        // 2. Gunakan Database Transaction
        try {
            DB::beginTransaction();

            // 3. Update tabel 'products'
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'price' => $request->price,
            ]);

            // 4. Update tabel 'product_details'
            // Kita bisa 'update' langsung karena relasi 1:1 sudah pasti ada
            $product->productDetail()->update([
                'description' => $request->description,
                'weight' => $request->weight,
                'size' => $request->size,
            ]);

            // 5. Commit
            DB::commit();

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil diperbarui.');

        } catch (\Exception $e) {
            // 6. Rollback
            DB::rollBack();
            return redirect()->back()
                             ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Menghapus data produk
     */
    public function destroy(Product $product)
    {
        // Hapus produk
        $product->delete();
        
        // Sesuai migration, 'onDelete cascade' akan otomatis:
        // 1. Menghapus 'product_details' yang terkait 
        // 2. Menghapus 'products_warehouses' (stok) yang terkait 

        return redirect()->route('products.index')
                         ->with('success', 'Produk berhasil dihapus. (Detail dan data stok terkait juga terhapus).');
    }
}