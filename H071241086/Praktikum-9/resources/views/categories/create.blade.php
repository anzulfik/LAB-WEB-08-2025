@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-white mb-2">
        Tambah Kategori
    </h1>
</div>

<div class="max-w-2xl">
    <div class="bg-white/5 backdrop-blur-xl rounded-2xl p-8 border border-white/10">

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-white/90 text-sm font-medium mb-2">
                    Nama Kategori
                </label>
                <input type="text" 
                       name="name"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all"
                       placeholder="Masukkan nama kategori"
                       required>
            </div>

            <div class="mb-8">
                <label class="block text-white/90 text-sm font-medium mb-2">
                    Deskripsi
                </label>
                <textarea name="description"
                          rows="4"
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-cyan-400/50 focus:bg-white/10 transition-all resize-none"
                          placeholder="Masukkan deskripsi (opsional)"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="px-6 py-2.5 bg-gradient-to-r from-cyan-400 to-blue-500 text-white rounded-xl font-medium hover:shadow-lg hover:shadow-cyan-500/50 transition-all duration-300">
                    Simpan
                </button>

                <a href="{{ route('categories.index') }}"
                   class="px-6 py-2.5 bg-white/5 border border-white/10 text-white/70 rounded-xl font-medium hover:bg-white/10 hover:text-white transition-all duration-300">
                    Batal
                </a>
            </div>
        </form>

    </div>
</div>

@endsection