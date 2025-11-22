<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::query()
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil diupdate');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')
                        ->with('success', 'Kategori berhasil dihapus');
    }
}