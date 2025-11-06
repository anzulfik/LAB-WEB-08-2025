@extends('layouts.app')

@section('title', 'Daftar Ikan')

@section('content')
<div class="min-h-screen bg-[url('{{ asset('images/ocean-day.jpeg') }}')] bg-cover bg-center bg-fixed flex flex-col items-center px-4 py-10 text-white font-[Orbitron] overflow-hidden">

    <!-- HEADER -->
    <div class="mt-10 text-center">
        <h1 class="relative flex items-center justify-center gap-4 text-5xl md:text-6xl font-extrabold bg-gradient-to-r from-sky-100 via-cyan-200 to-emerald-200 text-transparent bg-clip-text drop-shadow-[0_0_25px_rgba(255,255,255,0.6)] tracking-wider">
            <img src="{{ asset('images/fish-icon2.png') }}" 
                alt="Fish Icon" 
                class="h-16 w-16 md:h-20 md:w-20 object-contain drop-shadow-[0_0_18px_rgba(255,255,255,0.9)] animate-bounce-slow">
            <span class="tracking-wider">Daftar Ikan</span>

            {{-- Cahaya lembut di belakang teks --}}
            <span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-[360px] h-[100px] bg-cyan-400/30 blur-3xl rounded-full opacity-50"></span>
        </h1>

        <p class="text-cyan-50 italic text-base md:text-lg tracking-wide mt-3 drop-shadow-[0_0_10px_rgba(0,0,0,0.7)]">
            Koleksi ikan langka dari seluruh penjuru lautan 🌊
        </p>
    </div>

    <!-- FORM PENCARIAN + FILTER + SORT -->
    <form action="{{ route('fishes.index') }}" method="GET" class="mt-8 flex flex-wrap justify-center gap-3">
        <!-- Input Search -->
        <input type="text" name="search" placeholder="Cari ikan..."
            value="{{ request('search') }}"
            class="rounded-xl px-4 py-2 w-64 bg-white/30 text-gray-900 placeholder-gray-700 focus:outline-none focus:ring-2 focus:ring-cyan-400 font-semibold shadow-sm">

        <!-- Filter Rarity -->
        <select name="rarity"
            class="rounded-xl px-4 py-2 bg-white/30 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 font-semibold">
            <option value="">Semua Rarity</option>
            @foreach($rarities as $rarity)
                <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                    {{ $rarity }}
                </option>
            @endforeach
        </select>

        <!-- 🔽 Dropdown Urutkan -->
        <select name="sort"
            class="rounded-xl px-4 py-2 bg-white/30 text-gray-900 focus:outline-none focus:ring-2 focus:ring-cyan-400 font-semibold">
            <option value="">Urutkan Berdasarkan</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z) 🔠</option>
            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga per Kg (Tertinggi) 💰</option>
            <option value="probability" {{ request('sort') == 'probability' ? 'selected' : '' }}>Peluang Tertinggi 🎯</option>
        </select>

        <!-- Tombol Cari -->
        <button type="submit" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white font-semibold shadow-md transition">
            🔍 Cari
        </button>

        <!-- Tombol Tambah -->
        <a href="{{ route('fishes.create') }}" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold shadow-md transition">
            ➕ Tambah Ikan
        </a>
    </form>

    <!-- GRID LIST IKAN -->
    <div class="mt-10 w-full max-w-6xl overflow-y-auto scrollbar-hide" style="max-height: 70vh;">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 justify-items-center">
            @forelse($fishes as $fish)
                @php
                    $rarity = strtolower($fish->rarity);
                    $iconPath = match($rarity) {
                        'common' => 'images/fish-common.png',
                        'uncommon' => 'images/fish-uncommon.png',
                        'rare' => 'images/fish-rare.png',
                        'epic' => 'images/fish-epic.png',
                        'legendary' => 'images/fish-legendary.png',
                        'secret' => 'images/fish-secret.png',
                        default => 'images/fish-icon2.png',
                    };
                @endphp

                <div class="relative bg-gradient-to-br from-cyan-800/50 to-blue-900/60 backdrop-blur-lg border border-cyan-400/20 rounded-2xl shadow-lg p-5 w-64 text-center transition transform hover:scale-105 hover:shadow-cyan-500/30">

                    {{-- Glow efek per rarity --}}
                    <div class="absolute inset-0 rounded-2xl blur-2xl opacity-30 -z-10
                        @if($rarity === 'secret') bg-pink-500
                        @elseif($rarity === 'legendary') bg-yellow-400
                        @elseif($rarity === 'epic') bg-purple-500
                        @elseif($rarity === 'rare') bg-blue-400
                        @elseif($rarity === 'uncommon') bg-green-400
                        @else bg-cyan-300 @endif">
                    </div>

                    <div class="flex justify-center mb-3">
                        <img src="{{ asset($iconPath) }}" 
                             alt="{{ $fish->rarity }} Icon" 
                             class="w-16 h-16 object-contain opacity-95 drop-shadow-[0_0_12px_rgba(255,255,255,0.6)] hover:scale-110 transition-transform duration-300">
                    </div>

                    <h2 class="text-lg font-bold text-cyan-100">{{ $fish->name }}</h2>
                    <p class="text-sm italic mb-2 
                        @if($rarity === 'secret') text-pink-400 
                        @elseif($rarity === 'legendary') text-yellow-300 
                        @elseif($rarity === 'epic') text-purple-300
                        @elseif($rarity === 'rare') text-blue-300 
                        @elseif($rarity === 'uncommon') text-green-300
                        @else text-cyan-200 
                        @endif">
                        Rarity: {{ ucfirst($fish->rarity) }}
                    </p>

                    <p class="text-xs text-cyan-200">Berat: {{ number_format($fish->base_weight_min, 2) }} - {{ number_format($fish->base_weight_max, 2) }} kg</p>
                    <p class="text-xs text-cyan-200">Harga/kg: {{ number_format($fish->sell_price_per_kg) }}</p>
                    <p class="text-xs text-cyan-200 mb-3">Peluang: {{ number_format($fish->catch_probability, 2) }}%</p>

                    <div class="flex justify-center gap-2">
                        <a href="{{ route('fishes.show', $fish) }}" class="bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-md text-xs text-white transition">Detail</a>
                        <a href="{{ route('fishes.edit', $fish) }}" class="bg-yellow-500 hover:bg-yellow-600 px-2 py-1 rounded-md text-xs text-white transition">Edit</a>
                        
                        <!-- Tombol Hapus dengan SweetAlert2 -->
                        <form id="delete-form-{{ $fish->id }}" action="{{ route('fishes.destroy', $fish) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                onclick="confirmDelete('{{ $fish->id }}', '{{ $fish->name }}')"
                                class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded-md text-xs text-white transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-cyan-100 text-center col-span-full text-lg font-semibold">Tidak ada ikan ditemukan 🐠</p>
            @endforelse
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $fishes->links() }}
    </div>
</div>

{{-- 💎 SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus ikan ini?',
        text: `Apakah kamu yakin ingin menghapus ikan "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}

// Tampilkan notifikasi sukses setelah aksi CRUD
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    })
@endif
</script>

<style>
@keyframes bounce-slow {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
.animate-bounce-slow {
  animation: bounce-slow 3s infinite ease-in-out;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
@endsection
