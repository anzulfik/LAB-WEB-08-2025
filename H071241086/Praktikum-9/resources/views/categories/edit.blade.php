@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2">Edit Kategori</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
        <p class="text-gray-400 mt-3">Perbarui informasi kategori</p>
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
                Form Edit Kategori
            </h2>
        </div>

        <div class="p-8">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Nama Kategori
                    </label>
                    <input type="text" 
                           name="name"
                           value="{{ $category->name }}"
                           class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300"
                           placeholder="Masukkan nama kategori"
                           required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label class="block text-cyan-300 font-semibold text-sm uppercase tracking-wide mb-3">
                        Deskripsi
                    </label>
                    <textarea name="description"
                              rows="5"
                              class="w-full bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300 resize-none"
                              placeholder="Masukkan deskripsi kategori (opsional)">{{ $category->description }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-purple-500/20">
                    <a href="{{ route('categories.index') }}"
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
                        UPDATE KATEGORI
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection