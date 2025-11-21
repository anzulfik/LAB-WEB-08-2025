{{-- resources/views/warehouses/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Gudang')
@section('page_title', 'Edit Gudang')

@section('content')
<div class="card max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Edit Gudang</h2>

    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Gudang</label>
            <input type="text" name="name" value="{{ old('name', $warehouse->name) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-rose-500 focus:outline-none" required>
            @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <input type="text" name="location" value="{{ old('location', $warehouse->location) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-rose-500 focus:outline-none">
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('warehouses.index') }}"
               class="text-gray-600 hover:text-gray-800 transition">← Kembali</a>
            <button type="submit"
                    class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
