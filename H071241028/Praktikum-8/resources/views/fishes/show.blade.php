@extends('layouts.app')

@section('content')
<style>
    /* 🔒 Matikan scroll agar tampilan fix di layar */
    html, body {
        height: 100vh;
        margin: 0;
        padding: 0;
        overflow: hidden !important;
    }
    main, .container, .min-h-screen {
        overflow: hidden !important;
        height: 100vh !important;
    }
</style>

<div class="fixed inset-0 bg-[url('/images/deepsea.jpeg')] bg-cover bg-center flex items-center justify-center text-white font-[Orbitron]">

    {{-- 🪸 CARD DETAIL --}}
    <div class="bg-black/20 backdrop-blur-sm border border-cyan-400/40 rounded-2xl shadow-[0_0_25px_rgba(6,182,212,0.6)] p-8 w-[650px] max-w-[90%] text-center">

        {{-- HEADER --}}
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-cyan-300 drop-shadow-[0_0_10px_#06b6d4] tracking-wide flex items-center justify-center gap-3">
                <img src="{{ asset('images/fishpurple-icon.png') }}" 
                    alt="Detail Ikan" 
                    class="h-10 w-10 md:h-12 md:w-12 object-contain drop-shadow-[0_0_12px_rgba(34,211,238,0.8)]">
                <span>Detail Ikan</span>
            </h2>
            <p class="text-gray-300 text-xs italic mt-1">
                Eksplorasi dunia bawah laut penuh keindahan 🌊
            </p>
        </div>

        {{-- 🐟 ISI KONTEN --}}
        <div class="flex flex-col md:flex-row gap-6 items-center justify-center">

            {{-- GAMBAR / IKON BERDASARKAN RARITY --}}
            @php
                $iconMap = [
                    'Common' => 'fish-common.png',
                    'Uncommon' => 'fish-uncommon.png',
                    'Rare' => 'fish-rare.png',
                    'Epic' => 'fish-epic.png',
                    'Legendary' => 'fish-legendary.png',
                    'Secret' => 'fish-secret.png',
                    'Mythic' => 'fish-crystal.png'
                ];
                $iconFile = $iconMap[$fish->rarity] ?? 'fish-icon.png';
            @endphp

            <div class="flex-shrink-0 w-40 h-40 rounded-full border-4 border-cyan-400/60 shadow-[0_0_20px_rgba(6,182,212,0.7)] flex items-center justify-center bg-gradient-to-b from-cyan-400/10 to-transparent">
                <img src="{{ asset('images/' . $iconFile) }}" 
                    alt="Ikan Icon"
                    class="w-28 h-28 object-contain drop-shadow-[0_0_15px_rgba(34,211,238,0.8)]">
            </div>

            {{-- INFORMASI IKAN --}}
            <div class="flex-1 space-y-3 text-center md:text-left">
                <h3 class="text-2xl font-extrabold text-cyan-200 drop-shadow-[0_0_8px_#22d3ee]">
                    {{ $fish->name }}
                </h3>

                <p class="text-sm text-gray-300 italic">
                    Rarity:
                    <span class="
                        @if($fish->rarity == 'Legendary') text-yellow-400
                        @elseif($fish->rarity == 'Epic') text-purple-400
                        @elseif($fish->rarity == 'Rare') text-blue-400
                        @elseif($fish->rarity == 'Mythic') text-pink-400
                        @elseif($fish->rarity == 'Secret') text-red-400
                        @else text-gray-300
                        @endif font-semibold
                    ">
                        {{ $fish->rarity }}
                    </span>
                </p>

                <div class="grid grid-cols-2 gap-4 mt-3 text-sm">
                    <div>
                        <p class="text-gray-400">Berat Minimum</p>
                        <p class="text-lg font-semibold">{{ $fish->base_weight_min }} kg</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Berat Maksimum</p>
                        <p class="text-lg font-semibold">{{ $fish->base_weight_max }} kg</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Harga per Kg</p>
                        <p class="text-lg font-semibold">{{ $fish->sell_price_per_kg }} 💰</p>
                    </div>
                    <div>
                        <p class="text-gray-400">Peluang Tertangkap</p>
                        <p class="text-lg font-semibold">{{ $fish->catch_probability }}%</p>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mt-4 bg-white/5 rounded-xl p-4 border border-cyan-400/30">
                    <p class="text-sm text-gray-100 leading-relaxed">
                        {{ $fish->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- 🔘 TOMBOL AKSI --}}
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            {{-- Tombol Edit --}}
            <a href="{{ route('fishes.edit', $fish) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
                ✏️ Edit
            </a>

            {{-- Tombol Hapus --}}
            <form id="delete-form-{{ $fish->id }}" action="{{ route('fishes.destroy', $fish) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="button"
                    onclick="confirmDelete('{{ $fish->id }}')"
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
                    🗑️ Hapus
                </button>
            </form>

            {{-- Tombol Kembali --}}
            <a href="{{ route('fishes.index') }}"
                class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-lg font-semibold shadow-md transition-transform hover:scale-105">
                ⬅️ Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

{{-- 💎 SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ikan ini akan dihapus secara permanen!",
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
</script>
@endsection
