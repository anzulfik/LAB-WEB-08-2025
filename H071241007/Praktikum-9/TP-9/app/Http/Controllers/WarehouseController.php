<?php

namespace App\Http\Controllers;

use App\Models\Warehouse; // 1. Import Model Warehouse
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    // tampilkan data
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }
    
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Menyimpan data dari form create
     */
    public function store(Request $request)
    {
        // Validasi input 
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        // Simpan data
        Warehouse::create($request->all());

        // Redirect
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil ditambahkan.');
    }


    public function show(Warehouse $warehouse)
    {
        // ambil data trus redirect
        $warehouse->load('products'); 
        return view('warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }


    public function update(Request $request, Warehouse $warehouse)
    {
        // Validasi input 
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
        ]);

        // Update data
        $warehouse->update($request->all());

        // Redirect
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    /**
     * Menghapus data gudang
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Gudang berhasil dihapus.');
    }
}