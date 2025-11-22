<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductWarehouse;
use App\Models\Product;
use App\Models\Warehouse;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::with('detail')->paginate(10);
        $warehouses = Warehouse::all();

        $pivot = ProductWarehouse::get();

        $stockMatrix = [];

        foreach ($products as $product) {
            foreach ($warehouses as $warehouse) {
                $match = $pivot
                    ->where('product_id', $product->id)
                    ->where('warehouse_id', $warehouse->id)
                    ->first();

                $stockMatrix[$product->id][$warehouse->id] =
                    $match ? $match->quantity : 0;
            }
        }

        return view('stocks.index', compact('products', 'warehouses', 'stockMatrix'));
    }

    public function transferForm()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();

        return view('stocks.transfer', compact('products', 'warehouses'));
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'product_id'   => 'required',
            'warehouse_id' => 'required',
            'quantity'     => 'required|integer|not_in:0',
        ]);

        $quantity = $request->quantity;

        $stock = ProductWarehouse::firstOrCreate(
            [
                'product_id'   => $request->product_id,
                'warehouse_id' => $request->warehouse_id,
            ],
            ['quantity' => 0]
        );

        // Jika input minus, cek apakah stok cukup
        if ($quantity < 0) {
            if ($stock->quantity == 0) {
                return back()->with('error', 'Stok belum ada di gudang ini. Tidak bisa mengurangi stok.');
            }

            if ($stock->quantity < abs($quantity)) {
                return back()->with('error', "Stok tidak cukup. Stok saat ini: {$stock->quantity}, diminta: " . abs($quantity));
            }
        }

        // Update stok
        $stock->quantity += $quantity;
        $stock->save();

        $product = Product::find($request->product_id);
        $warehouse = Warehouse::find($request->warehouse_id);

        if ($quantity > 0) {
            $message = "Berhasil menambah {$quantity} unit {$product->name} di {$warehouse->name}";
        } else {
            $message = "Berhasil mengurangi " . abs($quantity) . " unit {$product->name} dari {$warehouse->name}";
        }

        return redirect()->route('stocks.index')->with('success', $message);
    }
}