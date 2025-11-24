@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-100 mb-6 tracking-wider">REGISTRASI SPESIMEN BARU</h1>

    <div class="bg-black/30 backdrop-blur-md rounded-lg border border-blue-500/30 overflow-hidden shadow-lg">
        <form action="{{ route('ikan.store') }}" method="POST">
            @csrf
            <div class="p-8">
                @if ($errors->any())
                    <div class="bg-red-500/10 border border-red-500/30 text-red-300 px-4 py-3 rounded-md relative mb-6">
                        <strong class="font-bold">ERROR INPUT:</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-400 mb-1">Designasi (Nama)</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                               placeholder="e.g., Hiu Siber">
                    </div>
                    <div>
                        <label for="rarity" class="block text-sm font-medium text-gray-400 mb-1">Kelas Rarity</label>
                        <select id="rarity" name="rarity" required
                                class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 px-3 py-2">
                            @foreach ($rarities as $rarity)
                                <option value="{{ $rarity }}" {{ old('rarity') == $rarity ? 'selected' : '' }}>
                                    {{ strtoupper($rarity) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="base_weight_min" class="block text-sm font-medium text-gray-400 mb-1">Berat Min. (kg)</label>
                        <input type="number" name="base_weight_min" id="base_weight_min" value="{{ old('base_weight_min') }}" required step="0.01"
                               class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                               placeholder="e.g., 50.50">
                    </div>
                    <div>
                        <label for="base_weight_max" class="block text-sm font-medium text-gray-400 mb-1">Berat Max. (kg)</label>
                        <input type="number" name="base_weight_max" id="base_weight_max" value="{{ old('base_weight_max') }}" required step="0.01"
                               class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                               placeholder="e.g., 120.75">
                    </div>
                    <div>
                        <label for="sell_price_per_kg" class="block text-sm font-medium text-gray-400 mb-1">Nilai (Kredit/kg)</label>
                        <input type="number" name="sell_price_per_kg" id="sell_price_per_kg" value="{{ old('sell_price_per_kg') }}" required step="1"
                               class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                               placeholder="e.g., 5000">
                    </div>
                    <div>
                        <label for="catch_probability" class="block text-sm font-medium text-gray-400 mb-1">Probabilitas Tangkap (%)</label>
                        <input type="number" name="catch_probability" id="catch_probability" value="{{ old('catch_probability') }}" required step="0.01" min="0.01" max="100"
                               class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                               placeholder="0.01 - 100">
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-400 mb-1">Catatan Data (Opsional)</label>
                        <textarea name="description" id="description" rows="4"
                                  class="block w-full bg-gray-900/50 border border-gray-600 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm text-gray-200 placeholder-gray-500 px-3 py-2"
                                  placeholder="Catat karakteristik spesimen...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="bg-black/30 px-8 py-4 text-right border-t border-blue-500/30">
                <a href="{{ route('ikan.index') }}" class="py-2 px-4 border border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-300 bg-gray-500/10 hover:bg-gray-500/20 transition-colors">
                    BATAL
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-blue-500 rounded-md shadow-sm text-sm font-medium text-blue-300 bg-blue-500/10 hover:bg-blue-500/20 transition-colors">
                    SIMPAN KE DATABASE
                </button>
            </div>
        </form>
    </div>
@endsection