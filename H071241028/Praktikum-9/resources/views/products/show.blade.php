{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page_title', 'Detail Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-700">Detail Produk</h2>
            <a href="{{ route('products.index') }}"
               class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg transition text-sm">
                ← Kembali ke Daftar
            </a>
        </div>

        {{-- Bagian utama produk --}}
        <div class="flex flex-col md:flex-row gap-6">
            {{-- Placeholder gambar produk --}}
            <div class="flex-shrink-0 w-full md:w-1/3">
                <div class="bg-gray-100 border rounded-lg flex items-center justify-center aspect-square overflow-hidden">
                    <img src="{{ asset('images/iconkardus.png') }}" 
                        alt="Gambar Produk" 
                        class="object-cover w-full h-full">
                </div>
            </div>

            {{-- Informasi produk --}}
            <div class="flex-1 space-y-3 text-gray-700">
                <p>
                    <span class="block text-sm font-semibold text-gray-600">Nama Produk:</span>
                    <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                        {{ $product->name }}
                    </span>
                </p>

                <p>
                    <span class="block text-sm font-semibold text-gray-600">Kategori:</span>
                    @if($product->category)
                        <span class="inline-block bg-blue-100 text-blue-700 font-semibold text-xs px-3 py-1 rounded mt-1">
                            {{ $product->category->name }}
                        </span>
                    @else
                        <span class="text-gray-500 block mt-1">-</span>
                    @endif
                </p>

                <p>
                    <span class="block text-sm font-semibold text-gray-600">Harga:</span>
                    <span id="priceDisplay"
                          class="block text-rose-600 font-bold text-lg bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </p>

                <p>
                    <span class="block text-sm font-semibold text-gray-600">Deskripsi:</span>
                    <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1 leading-relaxed">
                        {{ $product->detail->description ?? '-' }}
                    </span>
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <p>
                        <span class="block text-sm font-semibold text-gray-600">Berat:</span>
                        <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                            {{ $product->detail->weight ?? '-' }} gram
                        </span>
                    </p>
                    <p>
                        <span class="block text-sm font-semibold text-gray-600">Ukuran:</span>
                        <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                            {{ $product->detail->size ?? '-' }}
                        </span>
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-sm text-gray-500">
                    <p>🕒 Dibuat: {{ $product->created_at->format('d M Y, H:i') }}</p>
                    <p>♻️ Diperbarui: {{ $product->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script efek animasi harga (angka naik halus) --}}
<script>
    const priceDisplay = document.getElementById('priceDisplay');
    if (priceDisplay) {
        const text = priceDisplay.textContent.replace(/[^\d]/g, '');
        const target = parseInt(text);
        let current = 0;
        const step = Math.ceil(target / 40); // animasi cepat
        const interval = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(interval);
            }
            priceDisplay.textContent = 'Rp' + current.toLocaleString('id-ID');
        }, 20);
    }
</script>
@endsection
