@extends('layouts.app')
@section('title', 'Manajemen Stok')
@section('content')

<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Stok.png') }}');">
    <div class="max-w-4xl mx-auto pt-28 pb-28">
        <div class="glass-container p-8">
            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                Manajemen Stok Produk
            </h2>

            <form method="GET" class="mb-6">
                <div class="flex items-center gap-3 bg-white/40 border border-white/40 backdrop-blur-md rounded-xl p-4 shadow-md">
                    <label class="font-semibold text-gray-700">Filter Gudang:</label>
                    <select name="warehouse_id"
                            onchange="this.form.submit()"
                            class="px-3 py-2 rounded-lg bg-white/60 border border-white/40 
                                backdrop-blur-md shadow-sm">
                        <option value="">-- Semua Gudang --</option>
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}"
                                {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>

            @if(isset($warehouse))
                <h3 class="text-xl font-bold text-blue-700 mb-3">
                    Gudang: {{ $warehouse->name }}
                </h3>

                <div class="overflow-hidden rounded-xl glass-table shadow">
                    <table class="w-full">
                        <thead class="bg-white/30 backdrop-blur-md border-b border-white/40">
                            <tr class="text-gray-700">
                                <th class="p-3 text-left font-semibold">Produk</th>
                                <th class="p-3 text-right font-semibold">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $s)
                            <tr class="hover:bg-white/40 transition border-b border-white/30">
                                <td class="p-3">{{ $s->name }}</td>
                                <td class="p-3 text-right">{{ $s->pivot->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $stocks->links() }}</div>

            @else
                <h3 class="text-xl font-bold text-blue-700 mb-3">
                    Total Stok Semua Gudang
                </h3>

                <div class="overflow-hidden rounded-xl glass-table shadow">
                    <table class="w-full">
                        <thead class="bg-white/30 backdrop-blur-md border-b border-white/40">
                            <tr class="text-gray-700">
                                <th class="p-3 text-left font-semibold">Produk</th>
                                <th class="p-3 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $prod)
                            <tr class="hover:bg-white/40 transition border-b border-white/30">
                                <td class="p-3">{{ $prod->name }}</td>
                                <td class="p-3 text-right">{{ $prod->warehouses->sum('pivot.quantity') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection
