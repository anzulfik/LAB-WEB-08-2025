{{-- resources/views/categories/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page_title', 'Edit Kategori Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Kategori</h2>

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

        {{-- Form Edit Kategori --}}
        <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Input Nama --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                       placeholder="Masukkan nama kategori" required>
            </div>

            {{-- Input Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (opsional)</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                          placeholder="Tuliskan deskripsi kategori">{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('categories.index') }}"
                   class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                    Batal
                </a>

                <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-lg shadow transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

