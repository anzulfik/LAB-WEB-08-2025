@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2">Edit Produk</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
        <p class="text-gray-400 mt-3">Perbarui informasi produk</p>
    </div>

    <div class="relative bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl overflow-hidden border border-cyan-400/20">
        
        <!-- Decorative corners -->
        <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
        <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

        <div class="bg-gradient-to-r from-yellow-500/20 via-orange-600/20 to-red-500/20 px-6 py-4 border-b border-orange-500/30">
            <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Form Edit Produk
            </h2>
        </div>

        <div class="p-8">
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                            Nama Produk
                        </label>
                        <input type="text" 
                               name="name"
                               value="{{ $product->name }}"
                               class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                               required>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                            Harga
                        </label>
                        <input type="number" 
                               step="0.01"
                               name="price"
                               value="{{ $product->price }}"
                               class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                               required>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Kategori <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                    </label>
                    <select name="category_id"
                            class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300">
                        <option value="" class="bg-[#1a1042]">-- Tanpa Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                    class="bg-[#1a1042]"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Section Detail Produk --}}
                <div class="my-8 pt-6 border-t border-purple-500/30">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Detail Produk
                    </h3>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                            Deskripsi <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300 resize-none">{{ $product->detail->description ?? '' }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- Berat --}}
                        <div>
                            <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                                Berat (kg)
                            </label>
                            <input type="number" 
                                   step="0.01"
                                   name="weight"
                                   value="{{ number_format($product->detail->weight, 2, '.', '') }}"
                                   class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                                   required>
                        </div>

                        {{-- Ukuran --}}
                        <div>
                            <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                                Ukuran <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                            </label>
                            <input type="text" 
                                   name="size"
                                   value="{{ $product->detail->size ?? '' }}"
                                   class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-purple-500/20">
                    <a href="{{ route('products.index') }}"
                       class="px-6 py-3 bg-transparent border-2 border-gray-400/50 text-gray-300 rounded-2xl hover:bg-gray-500/10 hover:border-gray-300 transition duration-200 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-2xl hover:shadow-[0_0_30px_rgba(234,179,8,0.6)] transition-all duration-300 font-bold transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        UPDATE PRODUK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection