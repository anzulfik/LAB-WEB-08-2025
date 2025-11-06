@extends('layouts.app')

@section('title', 'Edit Ikan')

@section('content')
{{-- 🌌 BACKGROUND FIXED PENUH --}}
<div class="fixed inset-0 bg-[url('/images/night-sea.jpeg')] bg-cover bg-center z-0"></div>

{{-- 💫 LAPISAN UTAMA --}}
<div class="relative z-10 min-h-screen flex items-center justify-center overflow-hidden text-white font-[Orbitron] select-none">

    {{-- ✨ BINTANG BERKEDIP --}}
    <div class="absolute inset-0 overflow-hidden z-0 pointer-events-none">
        @for($i = 0; $i < 25; $i++)
            <div class="star" style="
                top: {{ rand(0, 100) }}%;
                left: {{ rand(0, 100) }}%;
                width: {{ rand(2, 4) }}px;
                height: {{ rand(2, 4) }}px;
                animation-delay: {{ rand(0, 10) / 2 }}s;">
            </div>
        @endfor
    </div>

    {{-- 🌊 CARD UTAMA --}}
    <div class="relative z-10 bg-black/60 backdrop-blur-lg border border-cyan-400/40 rounded-3xl shadow-[0_0_25px_rgba(6,182,212,0.5)] p-8 w-[700px] max-w-[90%] text-white flex flex-col justify-center items-center">

        {{-- HEADER --}}
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-cyan-300 drop-shadow-[0_0_12px_#06b6d4] flex items-center justify-center gap-3">
                <img src="{{ asset('images/lobster-icon.png') }}" alt="Edit Icon" class="h-9 w-9 md:h-11 md:w-11 object-contain inline-block align-middle drop-shadow-[0_0_10px_rgba(56,189,248,0.8)]">
                <span>Edit Data Ikan</span>
            </h2>
            <p class="text-gray-300 italic text-sm">Perbarui informasi ikan langka di lautan malam 🌊</p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('fishes.update', $fish->id) }}" method="POST" class="w-full">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2 text-cyan-200">Nama Ikan</label>
                    <input type="text" name="name" value="{{ old('name', $fish->name) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Rarity</label>
                    <input type="text" name="rarity" value="{{ old('rarity', $fish->rarity) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Berat Minimum (kg)</label>
                    <input type="number" step="0.1" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Berat Maksimum (kg)</label>
                    <input type="number" step="0.1" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2 text-cyan-200">Harga per Kg</label>
                    <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Peluang Tertangkap (%)</label>
                    <input type="number" step="0.1" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Deskripsi</label>
                    <textarea name="description" rows="5"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">{{ old('description', $fish->description) }}</textarea>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-center gap-6 mt-10">
                <a href="{{ route('fishes.index') }}"
                    class="bg-gray-500/40 hover:bg-gray-400/60 text-white px-6 py-2 rounded-lg shadow-md transition">
                    ⬅ Kembali
                </a>
                <button type="submit"
                    class="bg-gradient-to-r from-cyan-500 to-sky-600 hover:from-cyan-400 hover:to-blue-500 text-white px-8 py-2 rounded-lg font-semibold shadow-[0_0_15px_rgba(34,211,238,0.5)] transition-transform transform hover:scale-105 duration-300">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 💫 CSS BINTANG --}}
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden; /* 🔒 Tidak bisa discroll sama sekali */
}
.star {
    position: absolute;
    background: rgba(56, 189, 248, 0.9);
    border-radius: 50%;
    box-shadow:
        0 0 6px rgba(56, 189, 248, 0.9),
        0 0 15px rgba(56, 189, 248, 0.7),
        0 0 25px rgba(56, 189, 248, 0.4);
    animation: twinkle 3s infinite ease-in-out;
}
@keyframes twinkle {
    0%, 100% { opacity: 0.9; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}
</style>
@endsection
