<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::with('category')
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhereHas('category', function($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
            })
            ->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'category_id'   => 'nullable', 
            'price'         => 'required|numeric',
            'weight'        => 'required|numeric',
        ]);

    
        $product = Product::create([
            'name'        => $request->name,
            'category_id' => $request->category_id ?: null, 
            'price'       => $request->price,
        ]);

       
        ProductDetail::create([
            'product_id'  => $product->id,
            'weight'      => $request->weight,
            'size'        => $request->size,
            'description' => $request->description ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan. Silakan input stok di menu Transfer Stok.');
    }

    public function show(Product $product)
    {
    
        $product->load('category', 'detail');

        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        
        $product->load('detail');

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'weight'      => 'required|numeric',
            'category_id' => 'nullable', 
        ]);

        $product->update([
            'name'        => $request->name,
            'category_id' => $request->category_id ?: null, 
            'price'       => $request->price,
        ]);

        $product->detail()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'weight'      => $request->weight,
                'size'        => $request->size,
                'description' => $request->description ?? null,
            ]
        );

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete(); 
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}