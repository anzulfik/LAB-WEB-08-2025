{{-- resources/views/stocks/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Stok Gudang')
@section('page_title', 'Manajemen Stok Gudang')

@section('content')
<div class="space-y-6">

    {{-- Header halaman --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h2 class="text-xl font-semibold text-gray-700">Manajemen Stok Produk per Gudang</h2>

        {{-- Tombol aksi stok --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('stocks.transfer') }}"
               class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
                🔄 Transfer Stok
            </a>
        </div>
    </div>

    {{-- Filter Gudang --}}
    <div class="card">
        <form method="GET" action="{{ route('stocks.index') }}" class="flex flex-col md:flex-row gap-4 md:items-end">
            <div class="flex-1">
                <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Gudang</label>
                <select name="warehouse_id" id="warehouse_id" onchange="this.form.submit()"
                        class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                    <option value="">-- Pilih Gudang --</option>
                    @foreach ($warehouses as $w)
                        <option value="{{ $w->id }}" {{ $selectedWarehouseId == $w->id ? 'selected' : '' }}>
                            {{ $w->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:w-1/3">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <input type="text"
                       value="{{ optional($warehouses->firstWhere('id', $selectedWarehouseId))->location ?? '-' }}"
                       class="w-full bg-gray-50 border-gray-300 rounded-lg px-3 py-2 text-gray-600" disabled>
            </div>
        </form>
    </div>

    {{-- Jika gudang dipilih --}}
    @if ($selectedWarehouseId)
        {{-- Ringkasan Stok --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card text-center">
                <h4 class="text-sm text-gray-500 font-semibold mb-1">Total Produk</h4>
                <p class="text-2xl font-bold text-gray-800">{{ $stocks->count() }}</p>
            </div>

            <div class="card text-center">
                <h4 class="text-sm text-gray-500 font-semibold mb-1">Total Stok</h4>
                <p class="text-2xl font-bold text-gray-800">{{ $stocks->sum('quantity') }}</p>
            </div>

            <div class="card text-center">
                <h4 class="text-sm text-gray-500 font-semibold mb-1">Total Nilai Produk</h4>
                <p class="text-2xl font-bold text-rose-600">
                    Rp{{ number_format($stocks->sum(fn($s) => (optional($s->product)->price ?? 0) * $s->quantity), 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Tabel Stok --}}
        <div class="card overflow-x-auto">
            <h5 class="text-lg font-semibold text-gray-700 mb-3">Daftar Stok di Gudang</h5>
            <table class="w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="py-3 px-4 text-left font-semibold">Produk</th>
                        <th class="py-3 px-4 text-left font-semibold">Harga</th>
                        <th class="py-3 px-4 text-left font-semibold">Jumlah Stok</th>
                        <th class="py-3 px-4 text-left font-semibold">Total Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stocks as $s)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-medium text-gray-800">
                                {{ optional($s->product)->name ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-rose-600 font-semibold">
                                Rp{{ number_format(optional($s->product)->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4">{{ $s->quantity }}</td>
                            <td class="py-3 px-4 font-semibold text-gray-700">
                                Rp{{ number_format((optional($s->product)->price ?? 0) * $s->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                Belum ada stok untuk gudang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    @else
        {{-- Jika belum memilih gudang --}}
        <div class="card text-center py-10">
            <p class="text-gray-500">🔍 Silakan pilih gudang terlebih dahulu untuk melihat daftar stok produk.</p>
        </div>
    @endif
</div>
@endsection
