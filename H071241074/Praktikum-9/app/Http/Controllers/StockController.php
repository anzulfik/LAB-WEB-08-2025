<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $warehouseId = $request->query('warehouse_id');

        if ($warehouseId) {
            $warehouse = Warehouse::with(['products' => function($q) {
                $q->withPivot('quantity');
            }])->findOrFail($warehouseId);

            $stocks = $warehouse->products()->paginate(6);
            return view('stocks.index', compact('warehouses', 'warehouse', 'stocks'));
        }

        $products = Product::with(['warehouses' => function($q){ $q->withPivot('quantity'); }])->paginate(6);
        return view('stocks.index', compact('warehouses', 'products'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('stocks.transfer', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer', 
        ]);

        $warehouseId = $data['warehouse_id'];
        $productId = $data['product_id'];
        $qty = (int) $data['quantity'];

        DB::transaction(function () use ($warehouseId, $productId, $qty) {
            $existing = DB::table('product_warehouse')
                ->where('product_id', $productId)
                ->where('warehouse_id', $warehouseId)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                $newQty = $existing->quantity + $qty;
                if ($newQty < 0) {
                    abort(422, 'Stok tidak boleh menjadi negatif.');
                }
                DB::table('product_warehouse')
                    ->where('id', $existing->id)
                    ->update([
                        'quantity' => $newQty,
                        'updated_at' => now(),
                    ]);
            } else {
                if ($qty < 0) {
                    abort(422, 'Tidak bisa mengurangi stok dari gudang yang belum memiliki produk.');
                }
                DB::table('product_warehouse')->insert([
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'quantity' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('stocks.index')->with('success', 'Transfer stok berhasil.');
    }
}
