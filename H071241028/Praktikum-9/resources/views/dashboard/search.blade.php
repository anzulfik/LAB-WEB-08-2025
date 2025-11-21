@extends('layouts.app')

@section('title', 'Hasil Pencarian')
@section('page_title', 'Hasil Pencarian')

@section('content')
<div class="space-y-8">

    <div class="bg-white p-5 rounded-xl shadow flex justify-between items-center">
        <h2 class="text-lg font-semibold text-gray-700">
            🔍 Hasil pencarian untuk: <span class="text-rose-600">"{{ $query }}"</span>
        </h2>
        <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-800">← Kembali ke Dashboard</a>
    </div>

    {{-- Produk --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 mb-3">🛒 Produk ({{ $products->count() }})</h3>
        @if($products->count())
            <ul class="divide-y">
                @foreach($products as $p)
                    <li class="py-2 flex justify-between">
                        <span>{{ $p->name }} ({{ $p->category->name ?? 'Tanpa kategori' }})</span>
                        <a href="{{ route('products.show', $p->id) }}" class="text-blue-600 hover:underline">Detail</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Tidak ada produk ditemukan.</p>
        @endif
    </div>

    {{-- Kategori --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 mb-3">📦 Kategori ({{ $categories->count() }})</h3>
        @if($categories->count())
            <ul class="list-disc ml-5 text-gray-700">
                @foreach($categories as $c)
                    <li>{{ $c->name }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Tidak ada kategori ditemukan.</p>
        @endif
    </div>

    {{-- Gudang --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 mb-3">🏭 Gudang ({{ $warehouses->count() }})</h3>
        @if($warehouses->count())
            <ul class="list-disc ml-5 text-gray-700">
                @foreach($warehouses as $w)
                    <li>{{ $w->name }} — {{ $w->location ?? '-' }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Tidak ada gudang ditemukan.</p>
        @endif
    </div>

    {{-- Stok --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 mb-3">📊 Stok ({{ $stocks->count() }})</h3>
        @if($stocks->count())
            <table class="w-full text-sm text-gray-700">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left py-2 px-3">Produk</th>
                        <th class="text-left py-2 px-3">Gudang</th>
                        <th class="text-right py-2 px-3">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $s)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">{{ $s->product->name ?? '-' }}</td>
                            <td class="py-2 px-3">{{ $s->warehouse->name ?? '-' }}</td>
                            <td class="py-2 px-3 text-right font-medium {{ $s->quantity >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $s->quantity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Tidak ada stok ditemukan.</p>
        @endif
    </div>

</div>
@endsection
