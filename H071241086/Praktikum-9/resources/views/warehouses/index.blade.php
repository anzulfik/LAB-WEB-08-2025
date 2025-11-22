@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold text-white mb-2">Daftar Warehouse</h1>
        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
    </div>
    <a href="{{ route('warehouses.create') }}"
       class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-2xl hover:shadow-[0_0_30px_rgba(34,211,238,0.6)] transition-all duration-300 transform hover:scale-105">
        + TAMBAH WAREHOUSE
    </a>
</div>

{{-- Form Pencarian --}}
<div class="bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl p-6 mb-6 border border-purple-500/20">
    <form action="{{ route('warehouses.index') }}" method="GET" class="flex gap-3">
        <input type="text" 
               name="search" 
               value="{{ $search ?? '' }}"
               placeholder="Cari berdasarkan nama atau lokasi gudang..." 
               class="flex-1 bg-[#1a1042]/50 border-2 border-purple-500/30 rounded-2xl px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-cyan-400 focus:shadow-[0_0_20px_rgba(34,211,238,0.3)] transition-all duration-300">
        
        <button type="submit" 
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold rounded-2xl hover:shadow-[0_0_30px_rgba(168,85,247,0.6)] transition-all duration-300">
            CARI
        </button>
        
        @if($search)
        <a href="{{ route('warehouses.index') }}" 
           class="px-6 py-3 bg-transparent border-2 border-pink-500/50 text-pink-300 font-bold rounded-2xl hover:bg-pink-500/10 hover:border-pink-400 transition-all duration-300">
            RESET
        </a>
        @endif
    </form>
</div>

{{-- Info hasil pencarian --}}
@if($search)
<div class="bg-cyan-500/10 border-2 border-cyan-400/40 rounded-2xl px-6 py-4 mb-6 backdrop-blur-sm">
    <p class="text-cyan-300">Hasil pencarian: <strong class="text-white">"{{ $search }}"</strong> - {{ $warehouses->total() }} gudang ditemukan</p>
</div>
@endif

<div class="relative bg-[#0a0e27]/40 backdrop-blur-xl rounded-3xl p-8 border border-cyan-400/20">
    
    <!-- Decorative corners -->
    <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
    <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-purple-500/30">
                    <th class="py-4 px-6 text-left text-cyan-300 font-bold text-sm tracking-wider">NAMA GUDANG</th>
                    <th class="py-4 px-6 text-left text-cyan-300 font-bold text-sm tracking-wider">LOKASI</th>
                    <th class="py-4 px-6 text-left text-cyan-300 font-bold text-sm tracking-wider">AKSI</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($warehouses as $warehouse)
                <tr class="border-b border-purple-500/20 hover:bg-purple-500/5 transition-colors duration-200">
                    <td class="py-4 px-6 text-white font-medium">{{ $warehouse->name }}</td>
                    <td class="py-4 px-6 text-gray-300">{{ $warehouse->location ?? '-' }}</td>
                    <td class="py-4 px-6">
                        <div class="flex gap-3">
                            <a href="{{ route('warehouses.show', $warehouse->id) }}"
                               class="px-4 py-2 bg-blue-500/20 border border-blue-400/50 text-blue-300 rounded-xl hover:bg-blue-500/30 hover:shadow-[0_0_15px_rgba(59,130,246,0.4)] transition-all duration-200 text-sm font-semibold">
                                LIHAT
                            </a>

                            <a href="{{ route('warehouses.edit', $warehouse->id) }}"
                               class="px-4 py-2 bg-yellow-500/20 border border-yellow-400/50 text-yellow-300 rounded-xl hover:bg-yellow-500/30 hover:shadow-[0_0_15px_rgba(234,179,8,0.4)] transition-all duration-200 text-sm font-semibold">
                                EDIT
                            </a>

                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}"
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="px-4 py-2 bg-red-500/20 border border-red-400/50 text-red-300 rounded-xl hover:bg-red-500/30 hover:shadow-[0_0_15px_rgba(239,68,68,0.4)] transition-all duration-200 text-sm font-semibold"
                                        onclick="return confirm('Hapus gudang ini?')">
                                    HAPUS
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-12 px-6 text-center">
                        <div class="text-gray-400 text-lg">
                            @if($search)
                                Tidak ada gudang yang ditemukan untuk "{{ $search }}"
                            @else
                                Belum ada data gudang
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $warehouses->appends(['search' => $search])->links() }}
    </div>

</div>
@endsection