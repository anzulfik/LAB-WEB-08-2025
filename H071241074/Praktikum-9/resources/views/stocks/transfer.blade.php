@extends('layouts.app')
@section('title', 'Transfer Stok')

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Transfer.png') }}');">
    <div class="max-w-3xl mx-auto pt-28 pb-24">
        <div class="relative glass-container p-8">
            <a href="{{ route('stocks.index') }}" 
            class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 text-2xl font-bold">
                &lt;
            </a>

            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                Transfer Stok Gudang
            </h2>

            <form action="{{ route('stocks.transfer.store') }}" method="POST" class="space-y-6 text-gray-800">
                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Gudang</label>
                    <select name="warehouse_id" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Produk</label>
                    <select name="product_id" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-gray-700">Jumlah (gunakan + / -)</label>
                    <input type="number" name="quantity" placeholder="+10 atau -5" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                </div>

                <div class="flex justify-center gap-4 mt-6">
                    <button type="submit" class="gradient-btn text-white font-semibold px-6 py-2 rounded-2xl shadow-md transition">
                        Proses
                    </button>

                    <a href="{{ route('stocks.index') }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-2xl shadow-md transition">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
