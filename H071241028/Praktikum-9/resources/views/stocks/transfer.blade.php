@extends('layouts.app')

@section('title', 'Transfer Stok')
@section('page_title', 'Update / Koreksi Stok')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="card">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Update Stok (+/-)</h2>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
                {{ session('error') }}
            </div>
        @endif

        {{-- Validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3">
                <ul class="list-disc ml-4 text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM TRANSFER (+ / -) --}}
        <form action="{{ route('stocks.transfer.process') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Gudang --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Gudang</label>
                <select name="warehouse_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Gudang --</option>
                    @foreach($warehouses as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Produk --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Produk</label>
                <select name="product_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah (+ tambah, - kurangi) --}}
            <div>
                <label class="text-sm font-medium text-gray-700">Jumlah (+ untuk menambah, - untuk mengurangi)</label>
                <input type="number" name="quantity"
                       class="w-full border rounded px-3 py-2"
                       placeholder="Contoh: 10 atau -5"
                       required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between">
                <a href="{{ route('stocks.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Batal
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700">
                    🔁 Proses
                </button>
            </div>
        </form>

    </div>

</div>
@endsection
