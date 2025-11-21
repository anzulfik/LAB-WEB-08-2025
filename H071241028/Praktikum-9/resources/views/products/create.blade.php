{{-- resources/views/products/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page_title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Produk Baru</h2>

        {{-- Pesan error validasi --}}
        @if ($errors->any())
            <div class="bg-rose-100 text-rose-700 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form tambah produk --}}
        <form action="{{ route('products.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Informasi Dasar Produk --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                           class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="Contoh: Laptop ASUS" required>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}"
                           class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
                           placeholder="Contoh: 7500000" required>
                    <p id="pricePreview" class="text-sm text-gray-500 mt-1 italic">Rp0</p>
                </div>
            </div>

            {{-- Pilih Kategori --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" id="category_id"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <hr class="my-4 border-gray-200">

            {{-- Detail Produk --}}
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Produk</h3>
            <div class="space-y-4">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
                              placeholder="Tambahkan deskripsi produk...">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Berat (gram)</label>
                        <input type="number" step="0.01" name="weight" id="weight"
                               value="{{ old('weight') }}"
                               class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
                               placeholder="Contoh: 1500" required>
                    </div>

                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
                        <input type="text" id="size" name="size" value="{{ old('size') }}"
                               class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
                               placeholder="Contoh: 15 inch">
                    </div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('products.index') }}"
                   class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                    Batal
                </a>

                <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-lg shadow transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script untuk preview harga --}}
<script>
    const priceInput = document.getElementById('price');
    const pricePreview = document.getElementById('pricePreview');

    priceInput?.addEventListener('input', () => {
        const value = parseFloat(priceInput.value || 0);
        pricePreview.textContent = 'Rp' + value.toLocaleString('id-ID');
    });
</script>
@endsection
