{{-- resources/views/categories/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Kategori')
@section('page_title', 'Tambah Kategori Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Kategori Baru</h2>

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

        {{-- Form tambah kategori --}}
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input nama kategori --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                       placeholder="Contoh: Elektronik, Pakaian, Perabot">
            </div>

            {{-- Input deskripsi kategori --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                          placeholder="Tambahkan deskripsi kategori">{{ old('description') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                    Batal
                </a>

                <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-lg shadow transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
