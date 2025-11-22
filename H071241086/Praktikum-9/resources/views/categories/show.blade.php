@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-white mb-2">Detail Kategori</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
        <p class="text-gray-400 mt-3">Informasi lengkap tentang kategori</p>
    </div>

    <div class="relative bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl overflow-hidden border border-cyan-400/20">
        
        <!-- Decorative corners -->
        <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
        <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

        <div class="bg-gradient-to-r from-cyan-500/20 via-purple-600/20 to-pink-500/20 px-6 py-4 border-b border-purple-500/30">
            <h2 class="text-white font-semibold text-lg">{{ $category->name }}</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 gap-6">
                {{-- Nama Kategori --}}
                <div class="border-b border-purple-500/20 pb-4">
                    <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wide mb-2">
                        Nama Kategori
                    </label>
                    <p class="text-xl font-bold text-white">
                        {{ $category->name }}
                    </p>
                </div>

                {{-- Deskripsi --}}
                <div class="border-b border-purple-500/20 pb-4">
                    <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wide mb-2">
                        Deskripsi
                    </label>
                    <p class="text-gray-300 leading-relaxed">
                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                    </p>
                </div>

                {{-- Informasi Waktu --}}
                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Waktu Pembuatan --}}
                    <div class="bg-green-500/10 rounded-2xl p-4 border-2 border-green-400/30 backdrop-blur-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-green-300 uppercase">
                                    Dibuat Pada
                                </p>
                                <p class="text-white font-medium mt-1">
                                    {{ $category->created_at->timezone('Asia/Makassar')->format('d M Y') }}
                                </p>
                                <p class="text-sm text-green-400">
                                    {{ $category->created_at->timezone('Asia/Makassar')->format('H:i') }} WITA
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Waktu Pembaruan --}}
                    <div class="bg-blue-500/10 rounded-2xl p-4 border-2 border-blue-400/30 backdrop-blur-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-blue-300 uppercase">
                                    Terakhir Diupdate
                                </p>
                                <p class="text-white font-medium mt-1">
                                    {{ $category->updated_at->timezone('Asia/Makassar')->format('d M Y') }}
                                </p>
                                <p class="text-sm text-blue-400">
                                    {{ $category->updated_at->timezone('Asia/Makassar')->format('H:i') }} WITA
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-purple-500/20">
                <a href="{{ route('categories.index') }}"
                   class="px-5 py-2.5 bg-transparent border-2 border-gray-400/50 text-gray-300 rounded-2xl hover:bg-gray-500/10 hover:border-gray-300 transition duration-200 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>

                <div class="flex gap-2">
                    <a href="{{ route('categories.edit', $category->id) }}"
                       class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-2xl hover:shadow-[0_0_30px_rgba(234,179,8,0.6)] transition duration-200 font-medium flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>

                    <form action="{{ route('categories.destroy', $category->id) }}"
                          method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                          class="inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-2xl hover:shadow-[0_0_30px_rgba(239,68,68,0.6)] transition duration-200 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection