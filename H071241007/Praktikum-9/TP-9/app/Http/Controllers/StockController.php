<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{

    public function index(Request $request)
    {
        // Data untuk Form Transfer (dropdown) 
        $products = Product::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();

        // Data untuk Tabel Stok (dengan filter)
        $stocks = collect();
        $selectedWarehouseId = $request->input('warehouse_id');

        if ($selectedWarehouseId) {
            // Jika ada gudang yang dipilih 
            $warehouse = Warehouse::find($selectedWarehouseId);
            $stocks = $warehouse->products;
        }
        return view('stock.index', compact('products', 'warehouses', 'stocks', 'selectedWarehouseId'
        ));
    }

    // proses transfer
    public function transfer(Request $request)
    {
        // Validasi input form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|not_in:0',
        ]);

        $productId = $request->product_id;
        $warehouseId = $request->warehouse_id;
        $amount = (int) $request->quantity; 

        $warehouse = Warehouse::find($warehouseId);
        $productInWarehouse = $warehouse->products()->find($productId);
        if ($productInWarehouse != null) {
            $currentStock = $productInWarehouse->pivot->quantity;
        } else {
            $currentStock = 0;
        }

        $newStock = $currentStock + $amount;

        // validasi agar stok tidak minus
        if ($newStock < 0) {
            return redirect()->back()
                ->with('error', "Stok tidak boleh minus! (Stok saat ini: $currentStock. Anda mencoba mengurangi: " . abs($amount) . ")")->withInput();
        }

        // update stok
        $warehouse->products()->syncWithoutDetaching([
            $productId => ['quantity' => $newStock]
        ]);

        return redirect()->route('stock.index', ['warehouse_id' => $warehouseId])
                         ->with('success', "Stok $amount unit berhasil diproses. Stok baru: $newStock");
    }
}