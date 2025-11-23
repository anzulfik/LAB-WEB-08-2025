@extends('layouts.app')

@section('content')
    <div class="bg-black/30 backdrop-blur-md rounded-lg border border-blue-500/30 overflow-hidden shadow-lg">
        
        <div class="p-6 border-b border-blue-500/30">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-100">{{ $fish->name }}</h1>
                    <span class="mt-1 text-lg font-semibold text-blue-400 tracking-widest">KELAS {{ strtoupper($fish->rarity) }}</span>
                </div>
                <div class="flex gap-2 justify-start">
                    <a href="{{ route('ikan.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-600 rounded-md text-sm font-medium text-gray-300 bg-gray-500/10 hover:bg-gray-500/20 transition-colors">
                        &lt;&lt; KEMBALI KE STREAM
                    </a>
                    <a href="{{ route('ikan.edit', $fish) }}" class="inline-flex items-center px-4 py-2 border border-yellow-500 rounded-md text-sm font-medium text-yellow-300 bg-yellow-500/10 hover:bg-yellow-500/20 transition-colors">
                        UBAH DATA
                    </a>
                    <form action="{{ route('ikan.destroy', $fish) }}" method="POST" onsubmit="return confirm('// Konfirmasi terminasi spesimen? //');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-500 rounded-md text-sm font-medium text-red-400 bg-red-500/10 hover:bg-red-500/20 transition-colors">
                            TERMINASI
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-8">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nilai (Kredit/kg)</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-100 neon-text">{{ $fish->formatted_price }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Probabilitas Tangkap</dt>
                    <dd class="mt-1 text-lg font-semibold text-green-400">{{ $fish->catch_probability }}%</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Kisaran Berat</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-100">{{ $fish->formatted_weight_range }}</dd>
                </div>
                
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Pertama Dicatat</dt>
                    <dd class="mt-1 text-lg text-gray-300">{{ $fish->created_at->format('Y-m-d // H:i:s') }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Update Terakhir</dt>
                    <dd class="mt-1 text-lg text-gray-300">{{ $fish->updated_at->format('Y-m-d // H:i:s') }}</dd>
                </div>

                <div class="sm:col-span-3">
                    <dt class="text-sm font-medium text-gray-500 border-b border-gray-700 pb-2 mb-2">Catatan Data</dt>
                    <dd class="mt-1 text-base text-gray-300 leading-relaxed max-w-none">
                        <p class="whitespace-pre-wrap">{!! e($fish->description ?? '// Tidak ada catatan data. //') !!}</p>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection