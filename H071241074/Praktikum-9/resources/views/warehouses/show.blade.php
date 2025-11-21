@extends('layouts.app')
@section('title', $warehouse->name)

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Produk.png') }}');">
    <div class="max-w-4xl mx-auto pt-28 pb-24">
        <div class="relative glass-container p-8">
            <a href="{{ route('warehouses.index') }}"
            class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 text-2xl font-bold">
                &lt;
            </a>

            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                {{ $warehouse->name }}
            </h2>

            <div class="space-y-6 text-gray-800">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Gudang</label>
                    <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                        {{ $warehouse->location ?: '-' }}
                    </div>
                </div>

                <hr>

                <h3 class="text-xl font-bold text-blue-700">Stok Produk di Gudang Ini</h3>

                <div class="rounded-xl overflow-hidden border border-white/40 bg-white/50 backdrop-blur-md shadow-md">
                    <table class="w-full text-gray-800">
                        <thead class="bg-white/60">
                            <tr>
                                <th class="p-3 text-left font-semibold">Produk</th>
                                <th class="p-3 text-right font-semibold">Jumlah Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($warehouse->products as $product)
                                <tr class="border-t border-white/40 hover:bg-white/40 transition">
                                    <td class="p-3">{{ $product->name }}</td>
                                    <td class="p-3 text-right">{{ $product->pivot->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-gray-500">
                                        Belum ada stok produk di gudang ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
