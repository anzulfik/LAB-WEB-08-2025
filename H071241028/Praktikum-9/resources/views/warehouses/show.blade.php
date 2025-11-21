{{-- resources/views/warehouses/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Gudang')
@section('page_title', 'Detail Gudang')

@section('content')
<div class="card max-w-2xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center border-b pb-3">
        <h2 class="text-xl font-semibold text-gray-700">Detail Gudang</h2>
        <a href="{{ route('warehouses.index') }}"
           class="text-gray-600 hover:text-gray-800 transition">← Kembali</a>
    </div>

    {{-- Detail Informasi --}}
    <div class="space-y-4">
        <div class="grid grid-cols-3 gap-2">
            <p class="text-gray-500 font-medium">Nama Gudang</p>
            <p class="col-span-2 text-gray-800">{{ $warehouse->name }}</p>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <p class="text-gray-500 font-medium">Lokasi</p>
            <p class="col-span-2 text-gray-800">{{ $warehouse->location ?? '-' }}</p>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <p class="text-gray-500 font-medium">Dibuat pada</p>
            <p class="col-span-2 text-gray-800">
                {{ $warehouse->created_at->format('d M Y, H:i') }}
            </p>
        </div>

        <div class="grid grid-cols-3 gap-2">
            <p class="text-gray-500 font-medium">Diperbarui pada</p>
            <p class="col-span-2 text-gray-800">
                {{ $warehouse->updated_at->format('d M Y, H:i') }}
            </p>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end gap-3 pt-4 border-t">
        <a href="{{ route('warehouses.edit', $warehouse->id) }}"
           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-4 py-2 rounded-lg transition">
            ✏️ Edit
        </a>

        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus gudang ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
                🗑️ Hapus
            </button>
        </form>
    </div>
</div>
@endsection
