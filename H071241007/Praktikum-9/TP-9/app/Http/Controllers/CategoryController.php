<?php

namespace App\Http\Controllers;

use App\Models\Category; // 1. Import Model Category
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // tampilkan data
    public function index()
    {
        // ambil semua data kategori, urutkan dari yang terbaru
        $categories = Category::latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('categories.create');
    }

    //Menyimpan data dari form create
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255', 
            'description' => 'nullable|string',
        ]);

        // Simpan data ke database
        Category::create($request->all());

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit 
     * Kita menggunakan 'Route Model Binding' (Category $category)
     * Laravel akan otomatis mencari kategori berdasarkan ID di URL.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Menyimpan data dari form edit
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // 2. Update data di database
        $category->update($request->all());

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori
     */
    public function destroy(Category $category)
    {
        // Hapus kategori
        $category->delete();
        
        // (Catatan: Sesuai migration , produk yang terkait 
        // akan otomatis di-set 'category_id' nya jadi NULL)

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
    
    /**
     * TUGAS: Menampilkan seluruh data mengenai produk 
     * Ini bisa jadi halaman detail kategori yang menampilkan 
     * produk-produk di dalamnya.
     */
    public function show(Category $category)
    {
        // Kita bisa ambil kategori beserta produk-produknya
        $category->load('products');

        return view('categories.show', compact('category'));
    }
}