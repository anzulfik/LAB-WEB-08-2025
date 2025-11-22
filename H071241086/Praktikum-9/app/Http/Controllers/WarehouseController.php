<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $warehouses = Warehouse::query()
            ->when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('location', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('warehouses.index', compact('warehouses', 'search'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function show($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('warehouses.show', compact('warehouse'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouses.index')
                        ->with('success', 'Gudang berhasil ditambahkan');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required'
        ]);
        

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')
                        ->with('success', 'Gudang berhasil diupdate');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')
                        ->with('success', 'Gudang berhasil dihapus');
    }
}