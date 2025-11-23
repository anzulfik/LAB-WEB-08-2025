@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-100 tracking-wider">STREAM DATABASE SPESIMEN</h1>
        <p class="text-sm text-blue-400">Data real-time organisme akuatik</p>
    </div>

    @if (session('success'))
        <div class="bg-green-500/10 border border-green-500/30 text-green-300 px-4 py-3 rounded-md relative mb-6 shadow-lg neon-glow" role="alert">
            <strong class="font-bold">SISTEM:</strong>
            <span class="block sm:inline ml-2">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-black/30 backdrop-blur-sm rounded-lg border border-gray-700/50 p-6 mb-8 shadow-lg">
        <h3 class="text-lg font-medium text-gray-200 mb-4 border-b border-gray-700/50 pb-2">PARAMETER KUERI</h3>
        <form action="{{ route('ikan.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4 items-center">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari berdasarkan designasi..." 
                    value="{{ $filters['search'] ?? '' }}"
                    class="flex-1 block w-full bg-gray-900/50 border border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2">
                
                <select name="rarity" class="block w-full md:w-56 bg-gray-900/50 border border-gray-600 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 px-3 py-2">
                    <option value="">SEMUA KELAS RARITY</option>
                    @foreach ($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ ($filters['rarity'] ?? '') == $rarity ? 'selected' : '' }}>
                            {{ strtoupper($rarity) }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="w-full md:w-auto inline-flex justify-center py-2 px-4 border border-blue-500 text-sm font-medium rounded-md text-blue-400 bg-blue-500/10 hover:bg-blue-500/20 transition-colors">
                    EKSEKUSI
                </button>
                <a href="{{ route('ikan.index') }}" class="w-full md:w-auto inline-flex justify-center py-2 px-4 border border-gray-600 text-sm font-medium rounded-md text-gray-400 bg-gray-500/10 hover:bg-gray-500/20 transition-colors text-center">
                    RESET
                </a>
            </div>
        </form>
    </div>

    <div class="flex flex-wrap gap-6 justify-center">

        @forelse ($fishes as $fish)
            <div class="w-full max-w-sm bg-black/20 backdrop-blur-md rounded-lg border border-blue-500/30 overflow-hidden flex flex-col transition-all duration-300 hover:border-blue-400 hover:shadow-2xl hover:shadow-blue-500/20">
                
                <div class="p-5 border-b border-blue-500/30">
                    <h3 class="text-xl font-bold text-gray-100 truncate">{{ $fish->name }}</h3>
                    <span class="text-sm font-medium text-blue-400 tracking-widest">KELAS {{ strtoupper($fish->rarity) }}</span>
                </div>
                
                <div class="px-5 py-4 ">
                    <dl class="space-y-3">
                        <div class="flex justify-between items-center">
                            <dt class="text-sm text-gray-400">Kisaran Berat</dt>
                            <dd class="text-sm font-medium text-gray-200 bg-gray-800/50 px-2 py-1 rounded">{{ $fish->formatted_weight_range }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-sm text-gray-400">Nilai Jual</dt>
                            <dd class="text-sm font-medium text-gray-200 bg-gray-800/50 px-2 py-1 rounded">{{ $fish->formatted_price }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-sm text-gray-400">Probabilitas Tangkap</dt>
                            <dd class="text-sm font-medium text-green-400 bg-green-900/50 px-2 py-1 rounded">{{ $fish->catch_probability }}%</dd>
                        </div>
                    </dl>
                </div>
                
                <div class="bg-black/30 px-5 py-3 flex justify-end gap-4 border-t border-blue-500/30">
                    <a href="{{ route('ikan.show', $fish) }}" class="text-blue-400 hover:text-blue-200 text-sm font-medium">LIHAT</a>
                    <a href="{{ route('ikan.edit', $fish) }}" class="text-yellow-400 hover:text-yellow-200 text-sm font-medium">UBAH</a>
                    <form action="{{ route('ikan.destroy', $fish) }}" method="POST" onsubmit="return confirm('// Konfirmasi terminasi spesimen? //');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-300 text-sm font-medium">HAPUS</button>
                    </form>
                </div>
            </div>
            
        @empty
            <div class="w-full text-center bg-black/30 backdrop-blur-sm border border-dashed border-gray-700 rounded-lg px-6 py-12 text-gray-500">
                <h3 class="text-lg font-medium text-gray-300">// TIDAK ADA DATA TERDETEKSI //</h3>
                <p class="mt-1 text-sm">Sesuaikan parameter kueri atau registrasi spesimen baru.</p>
            </div>
        @endforelse

    </div>

    @if ($fishes->hasPages())
        <div class="mt-8 text-center">
            {{ $fishes->links() }}
        </div>
    @endif

@endsection