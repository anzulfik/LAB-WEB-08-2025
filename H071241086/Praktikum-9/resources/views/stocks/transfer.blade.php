@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2">Transfer Stok</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
        <p class="text-gray-400 mt-3">Tambah atau kurangi stok produk di warehouse</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/10 border-2 border-red-400/40 rounded-2xl px-6 py-4 mb-6 backdrop-blur-sm">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-red-300 font-semibold mb-2">Terdapat kesalahan input:</p>
                    <ul class="list-disc ml-5 text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/10 border-2 border-red-400/40 rounded-2xl px-6 py-4 mb-6 backdrop-blur-sm">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-300 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="relative bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl overflow-hidden border border-cyan-400/20">
        
        <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
        <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

        <div class="bg-gradient-to-r from-green-500/20 via-emerald-600/20 to-teal-500/20 px-6 py-4 border-b border-green-500/30">
            <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Form Transfer Stok
            </h2>
        </div>

        <div class="p-8">
            <form action="{{ route('stocks.transfer') }}" method="POST">
                @csrf

                {{-- Info Box --}}
                <div class="bg-cyan-500/10 border-2 border-cyan-400/30 rounded-2xl px-5 py-4 mb-6 backdrop-blur-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-cyan-300 text-sm">
                            <p class="font-semibold mb-1">Cara Penggunaan:</p>
                            <ul class="list-disc ml-5 space-y-1">
                                <li>Gunakan angka <strong class="text-green-400">positif (+)</strong> untuk menambah stok</li>
                                <li>Gunakan angka <strong class="text-red-400">negatif (-)</strong> untuk mengurangi stok</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Pilih Gudang --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Pilih Gudang
                        </span>
                    </label>
                    <select name="warehouse_id"
                            class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                            required>
                        <option value="" class="bg-[#1a1042]">Pilih Gudang</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}" class="bg-[#1a1042]">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Produk --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Pilih Produk
                        </span>
                    </label>
                    <select name="product_id"
                            class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                            required>
                        <option value="" class="bg-[#1a1042]">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" class="bg-[#1a1042]">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Input Jumlah Stok --}}
                <div class="mb-8">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                            </svg>
                            Jumlah Stok
                        </span>
                    </label>
                    <input type="number" 
                           name="quantity"
                           class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                           placeholder="Contoh: 10 (tambah) atau -10 (kurangi)"
                           required>
                    <p class="text-gray-400 text-sm mt-2 ml-1">
                        💡 Tip: Gunakan tanda minus (-) untuk mengurangi stok
                    </p>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-purple-500/20">
                    <a href="{{ route('stocks.index') }}"
                       class="px-6 py-3 bg-transparent border-2 border-gray-400/50 text-gray-300 rounded-2xl hover:bg-gray-500/10 hover:border-gray-300 transition duration-200 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-2xl hover:shadow-[0_0_30px_rgba(34,197,94,0.6)] transition-all duration-300 font-bold transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        SIMPAN TRANSFER
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection