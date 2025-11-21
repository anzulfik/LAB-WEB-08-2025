@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Produk.png') }}');">
    <div class="max-w-4xl mx-auto pt-28 pb-24">
        <div class="relative glass-container p-8">
            <a href="{{ route('products.index') }}"
            class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 text-2xl font-bold">
                &lt;
            </a>

            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                {{ $product->name }}
            </h2>

            <div class="space-y-6 text-gray-800">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori</label>
                        <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                            {{ $product->category->name ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga</label>
                        <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                            Rp {{ number_format($product->price, 2, ',', '.') }}
                        </div>
                    </div>
                </div>

                <hr>

                <h3 class="text-xl font-bold text-blue-700">Detail Produk</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                        <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                            {{ $product->detail->description ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Berat (kg)</label>
                        <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                            {{ $product->detail->weight ?? '-' }} kg
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Ukuran</label>
                        <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                            {{ $product->detail->size ?? '-' }}
                        </div>
                    </div>
                </div>

                <hr>

                <h3 class="text-xl font-bold text-blue-700">Stok di Gudang</h3>

                <div class="rounded-xl overflow-hidden border border-white/40 bg-white/50 backdrop-blur-md shadow-md">
                    <table class="w-full text-gray-800">
                        <thead class="bg-white/60">
                            <tr>
                                <th class="p-3 text-left font-semibold">Gudang</th>
                                <th class="p-3 text-right font-semibold">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product->warehouses as $w)
                                <tr class="border-t border-white/40">
                                    <td class="p-3">{{ $w->name }}</td>
                                    <td class="p-3 text-right">{{ $w->pivot->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-gray-500">Belum ada stok</td>
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
