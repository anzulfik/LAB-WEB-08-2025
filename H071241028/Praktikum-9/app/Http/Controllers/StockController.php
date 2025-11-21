<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Halaman stok per gudang.
     */
    public function index(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouseId = $request->warehouse_id;
        $stocks = collect();

        if ($selectedWarehouseId) {
            $stocks = Stock::with('product')
                ->where('warehouse_id', $selectedWarehouseId)
                ->get();
        }

        return view('stocks.index', compact(
            'warehouses',
            'stocks',
            'selectedWarehouseId'
        ));
    }

    /**
     * Halaman transfer (update stok + / - )
     */
    public function showTransferForm()
    {
        return view('stocks.transfer', [
            'warehouses' => Warehouse::all(),
            'products'   => Product::all()
        ]);
    }

    /**
     * Proses update stok (+ atau -)
     */
    public function transfer(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|not_in:0', // + atau -
        ]);

        $stock = Stock::firstOrCreate(
            [
                'warehouse_id' => $request->warehouse_id,
                'product_id'   => $request->product_id,
            ],
            ['quantity' => 0]
        );

        $qty = (int) $request->quantity;

        // Jika mengurangi stok
        if ($qty < 0) {
            if ($stock->quantity < abs($qty)) {
                return back()->with('error', 'Stok tidak mencukupi untuk dikurangi!');
            }

            $stock->quantity -= abs($qty);
            $stock->save();

            return back()->with('success', 'Stok berhasil dikurangi!');
        }

        // Jika menambah stok
        if ($qty > 0) {
            $stock->quantity += $qty;
            $stock->save();

            return back()->with('success', 'Stok berhasil ditambahkan!');
        }

        return back()->with('error', 'Jumlah tidak valid!');
    }

    /**
     * Ajax cek stok
     */
    public function checkStock(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id'   => 'required|exists:products,id',
        ]);

        $stock = Stock::where('warehouse_id', $request->warehouse_id)
            ->where('product_id', $request->product_id)
            ->first();

        return response()->json([
            'quantity' => $stock->quantity ?? 0,
            'product'  => $stock?->product?->name,
        ]);
    }
}
