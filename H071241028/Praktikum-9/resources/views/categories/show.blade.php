{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Kategori')
@section('page_title', 'Detail Kategori Produk')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Detail Kategori</h2>

        <div class="space-y-3 text-gray-700">
            <p>
                <span class="font-semibold text-gray-800">Nama:</span><br>
                <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                    {{ $category->name }}
                </span>
            </p>

            <p>
                <span class="font-semibold text-gray-800">Deskripsi:</span><br>
                <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                    {{ $category->description ?? '-' }}
                </span>
            </p>

            <p>
                <span class="font-semibold text-gray-800">Dibuat pada:</span><br>
                <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                    {{ $category->created_at->format('d M Y, H:i') }}
                </span>
            </p>

            <p>
                <span class="font-semibold text-gray-800">Diperbarui pada:</span><br>
                <span class="block bg-gray-50 border rounded-lg px-4 py-2 mt-1">
                    {{ $category->updated_at->format('d M Y, H:i') }}
                </span>
            </p>
        </div>

        <div class="flex justify-end mt-6">
            <a href="{{ route('categories.index') }}"
               class="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection
