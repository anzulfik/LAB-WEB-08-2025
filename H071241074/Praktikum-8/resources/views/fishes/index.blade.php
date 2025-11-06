@extends('layouts.app')

@section('content')

<section id="welcome" class="relative text-center -mt-2 min-h-screen w-full bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/bg-fish-home.png') }}');">
    <img src="{{ asset('images/hiasan-ikan-tabel-index3.png') }}" alt="Hiasan ikan tabel" class="absolute -left-[680px] top-36 w-[2000px] object-cover pointer-events-none z-40"/>
    <div class="absolute z-10 mt-44">
        <h1 class="text-[110px] mt-5 mb-2 ml-12 text-[#2a5f68] leading-none text-left" style="font-family: 'Whitefish';">
            Sistem Manajemen <br> Fish It Roblox!
        </h1>
        <button 
            class="gradient-btn text-lg block ml-12 text-white font-semibold px-4 py-3 transition"
            onclick="scrollToTable()">
            Lihat Daftar Ikan
        </button>
    </div>
</section>

<section id="fish-table" class="mt-20 relative max-w-6xl mx-auto px-3">
    <img src="{{ asset('images/hiasan-ikan-tabel-index.png') }}" alt="Hiasan ikan tabel" class="absolute -left-32 -top-10 w-[2000px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index2.png') }}" alt="Hiasan ikan tabel" class="absolute left-32 top-42 w-[2000px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index3.png') }}" alt="Hiasan ikan tabel" class="absolute left-36 -top-2 w-[2000px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index4.png') }}" alt="Hiasan ikan tabel" class="absolute -left-32 -top-2 w-[2000px] object-cover pointer-events-none z-40"/>
    <div class="glass-container overflow-hidden rounded-2xl shadow-xl">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-6 py-5 border-b border-gray-200">
            <h2 class="text-3xl font-bold text-[#2a5f68] flex items-center gap-2">
                 <span>Daftar Ikan</span>
            </h2>
            <div class="flex flex-col sm:flex-row gap-3 items-center w-full lg:w-auto">
                <form method="GET" class="flex flex-wrap sm:flex-nowrap gap-3 w-full lg:w-auto">
                    <input type="text" name="search" value="{{ $search }}"
                        class="filter-input bg-white/70"
                        placeholder="Cari nama ikan...">

                    <select name="rarity" class="filter-input bg-white/70">
                        <option value="">Semua Rarity</option>
                        @foreach($rarities as $r)
                            <option value="{{ $r }}" {{ $r == $rarity ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>

                    <button class="gradient-btn font-semibold px-5 py-2.5 rounded-2xl shadow-md whitespace-nowrap">
                        Terapkan
                    </button>
                </form>

                <a href="{{ route('fishes.create') }}" 
                    class="gradient-btn hover:brightness-110 text-white px-6 py-2.5 rounded-2xl font-semibold shadow-md whitespace-nowrap">
                    + Tambah Ikan
                </a>
            </div>
        </div>

        <table class="min-w-full border-collapse">
            <thead class="bg-white/70 text-gray-800 border-b border-gray-300">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Nama</th>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Rarity</th>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Berat (kg)</th>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Harga</th>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Peluang (%)</th>
                    <th class="py-3 px-4 text-center font-semibold uppercase text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200/70 bg-white/60">
                @forelse($fishes as $fish)
                <tr class="hoverable">
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $fish->name }}</td>
                    <td class="py-3 px-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ 
                            match($fish->rarity) {
                                'Common' => 'bg-gray-200 text-gray-800',
                                'Rare' => 'bg-blue-200 text-blue-800',
                                'Epic' => 'bg-purple-200 text-purple-800',
                                'Legendary' => 'bg-yellow-200 text-yellow-800',
                                'Mythic' => 'bg-fuchsia-200 text-fuchsia-800',
                                'Secret' => 'bg-red-200 text-red-800',
                                default => 'bg-gray-100 text-gray-600'
                            } 
                        }}">
                            {{ $fish->rarity }}
                        </span>
                    </td>
                    <td class="py-3 px-4">{{ $fish->formatted_weight_range }}</td>
                    <td class="py-3 px-4 text-green-700 font-semibold">{{ $fish->formatted_price }}</td>
                    <td class="py-3 px-4 text-blue-600 font-medium">{{ $fish->catch_probability }}%</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('fishes.show', $fish) }}" 
                               class="gradient-btn text-sm font-medium px-4 py-2 rounded-2xl shadow-md">Lihat</a>
                            <a href="{{ route('fishes.edit', $fish) }}" 
                               class="gradient-btn text-white text-sm font-medium px-4 py-2 rounded-2xl shadow-md hover:brightness-110">Edit</a>
                            <button type="button" onclick="openDeleteModal('{{ route('fishes.destroy', $fish) }}')" 
                               class="gradient-red text-white text-sm font-medium px-4 py-2 rounded-2xl shadow-md hover:brightness-110">Hapus</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-6">
                        Belum ada data ikan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-gray-200 bg-white/50 text-center">
            {{ $fishes->links() }}
        </div>
    </div>
</section>

<div id="deleteModal" class="fixed inset-0 hidden justify-center items-center modal-bg z-50">
    <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 shadow-xl text-center max-w-sm mx-auto">
        <p class="text-lg font-semibold text-gray-800 mb-5">Yakin ingin menghapus ikan ini?</p>
        <div class="flex justify-center gap-4">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="gradient-red text-white font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                    Ya, Hapus
                </button>
            </form>
            <button onclick="closeModal()" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
function scrollToTable() {
    document.getElementById('fish-table').scrollIntoView({ behavior: 'smooth' });
}
function openDeleteModal(url) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>

@endsection
