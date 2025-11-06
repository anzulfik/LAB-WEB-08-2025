@extends('layouts.app')

@section('title', 'Tambah Ikan')

@section('content')
{{-- 🌅 BACKGROUND SENJA OCEAN --}}
<div class="fixed inset-0 bg-[url('/images/sunset-beach.jpeg')] bg-cover bg-center z-0"></div>

{{-- 🌊 LAPISAN UTAMA --}}
<div class="relative z-10 min-h-screen flex items-center justify-center text-white font-[Orbitron] select-none overflow-hidden">

    {{-- 💫 EFEK CAHAYA SENJA --}}
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/40 via-purple-800/40 to-transparent z-0"></div>

    {{-- 🌊 CARD TAMBAH IKAN --}}
    <div class="relative z-10 bg-gradient-to-br from-indigo-900/60 to-blue-800/40 backdrop-blur-lg border border-cyan-300/30 rounded-3xl shadow-[0_0_25px_rgba(56,189,248,0.5)] p-10 w-[750px] max-w-[95%]">

        {{-- HEADER --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl md:text-4xl font-bold text-cyan-200 drop-shadow-[0_0_15px_#22d3ee] flex items-center justify-center gap-3">
                <img src="{{ asset('images/sotong-icon.png') }}" 
                     alt="Tambah Ikan" 
                     class="h-10 w-10 md:h-12 md:w-12 object-contain drop-shadow-[0_0_10px_rgba(34,211,238,0.7)]">
                <span>Tambah Data Ikan</span>
            </h2>
            <p class="text-gray-300 italic text-sm mt-2">
                Masukkan informasi ikan baru yang ditemukan di samudra senja 🌅
            </p>
        </div>

        {{-- FORM --}}
        <form action="{{ route('fishes.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- GRID 2 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- KOLOM KIRI --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-cyan-200">Nama Ikan</label>
                    <input type="text" name="name" placeholder="Contoh: Tuna Biru"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Rarity</label>
                    <select name="rarity"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-gray-100 outline-none">
                        <option>Common</option>
                        <option>Uncommon</option>
                        <option>Rare</option>
                        <option>Epic</option>
                        <option>Legendary</option>
                    </select>

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Berat Minimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_min" placeholder="cth: 1.25"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Berat Maksimum (kg)</label>
                    <input type="number" step="0.01" name="base_weight_max" placeholder="cth: 8.75"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    <label class="block text-sm font-semibold mb-2 text-cyan-200">Harga per Kg (💰 Coins)</label>
                    <input type="number" name="sell_price_per_kg" placeholder="cth: 5000"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Peluang Tertangkap (%)</label>
                    <input type="number" step="0.01" name="catch_probability" placeholder="cth: 25.50"
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none">

                    <label class="block text-sm font-semibold mt-4 mb-2 text-cyan-200">Deskripsi</label>
                    <textarea name="description" rows="5" placeholder="Tuliskan deskripsi ikan..."
                        class="w-full px-3 py-2 rounded-lg bg-white/10 border border-cyan-400/40 focus:ring-2 focus:ring-cyan-400 text-white outline-none"></textarea>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-center gap-6 mt-10">
                <a href="{{ route('fishes.index') }}"
                    class="bg-gray-500/40 hover:bg-gray-400/60 text-white px-6 py-2 rounded-lg shadow-md transition">
                    ⬅ Kembali
                </a>
                <button type="submit"
                    class="bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-cyan-500 text-white px-8 py-2 rounded-lg font-semibold shadow-[0_0_15px_rgba(34,211,238,0.5)] transition-transform transform hover:scale-105 duration-300">
                    💾 Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 🌟 CSS TAMBAHAN --}}
<style>
html, body {
    height: 100%;
    overflow: hidden; /* 🔒 Tidak bisa discroll */
    margin: 0;
    padding: 0;
}

/* 🌊 Rarity Dropdown Styling */
select[name="rarity"] {
  appearance: none;
  background-color: rgba(15, 23, 42, 0.6); /* biru gelap transparan */
  color: #e0f7fa;
  border: 1px solid rgba(56, 189, 248, 0.5);
  border-radius: 10px;
  font-family: 'Orbitron', sans-serif;
}

/* Saat difokuskan */
select[name="rarity"]:focus {
  background-color: rgba(6, 182, 212, 0.2);
  outline: none;
  border-color: rgba(6, 182, 212, 0.8);
}

/* 🌌 Tampilan daftar pilihan dropdown */
select[name="rarity"] option {
  background-color: rgba(15, 23, 42, 0.95); /* warna biru tua */
  color: #e0f7fa;
  font-family: 'Orbitron', sans-serif;
}

/* Hover option */
select[name="rarity"] option:hover {
  background-color: rgba(56, 189, 248, 0.3);
}
</style>
@endsection
