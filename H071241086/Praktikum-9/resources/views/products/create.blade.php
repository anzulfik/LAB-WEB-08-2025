@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2">Tambah Produk</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
        <p class="text-gray-400 mt-3">Tambahkan produk baru ke inventory</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-500/10 border-2 border-red-400/40 rounded-2xl px-6 py-4 mb-6 backdrop-blur-sm">
            <p class="text-red-300 font-semibold mb-2">Terdapat kesalahan input:</p>
            <ul class="list-disc ml-5 text-red-400">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="relative bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl overflow-hidden border border-cyan-400/20">
        
        <!-- Decorative corners -->
        <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
        <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

        <div class="bg-gradient-to-r from-cyan-500/20 via-blue-600/20 to-purple-500/20 px-6 py-4 border-b border-cyan-500/30">
            <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Form Tambah Produk
            </h2>
        </div>

        <div class="p-8">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                {{-- Nama Produk --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Nama Produk
                    </label>
                    <input type="text" 
                           name="name"
                           class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                           placeholder="Masukkan nama produk"
                           required>
                </div>

                {{-- Kategori (OPSIONAL) --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Kategori <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                    </label>
                    <select name="category_id"
                            class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300">
                        <option value="" class="bg-[#1a1042]">-- Tanpa Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-[#1a1042]">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    {{-- Harga --}}
                    <div>
                        <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                            Harga Produk
                        </label>
                        <input type="number" 
                               step="0.01"
                               name="price"
                               min="0"
                               class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                               placeholder="0.00"
                               required>
                    </div>

                    {{-- Berat --}}
                    <div>
                        <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                            Berat Produk (kg)
                        </label>
                        <input type="number" 
                               step="0.01"
                               name="weight"
                               min="0.01"
                               class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                               placeholder="0.00"
                               required>
                    </div>
                </div>

                {{-- Ukuran --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Ukuran Produk <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="size"
                           class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                           placeholder="Contoh: L, XL, 42, dll">
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Deskripsi Produk <span class="text-gray-400 text-xs normal-case">(Opsional)</span>
                    </label>
                    <textarea name="description"
                              rows="4"
                              class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300 resize-none"
                              placeholder="Masukkan deskripsi produk"></textarea>
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
                            class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl hover:shadow-[0_0_30px_rgba(34,211,238,0.6)] transition-all duration-300 font-bold transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        SIMPAN PRODUK
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection