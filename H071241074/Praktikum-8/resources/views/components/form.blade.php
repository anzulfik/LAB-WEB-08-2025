<div class="max-w-3xl mx-auto mt-20">
    <div class="relative glass-container p-8 mt-20">
        <a href="{{ route('fishes.index') }}" 
           class="absolute top-4 left-4 text-gray-700 hover:text-[#2a5f68] font-semibold transition text-2xl leading-none">
            &lt;
        </a>

        <h2 class="text-3xl font-bold text-[#2a5f68] mb-8 text-center">
            {{ isset($fish) ? 'Edit Ikan' : 'Tambah Ikan Baru' }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Ikan</label>
                <input type="text" name="name" value="{{ old('name', $fish->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Rarity</label>
                <select name="rarity" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                    @foreach(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
                        <option value="{{ $r }}" 
                                {{ old('rarity', $fish->rarity ?? '') == $r ? 'selected' : '' }}>
                            {{ $r }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Berat Minimum (kg)</label>
                <input type="number" step="0.01" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Berat Maksimum (kg)</label>
                <input type="number" step="0.01" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Harga Jual per kg (Coins)</label>
                <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1 text-gray-700">Peluang Tertangkap (%)</label>
                <input type="number" step="0.01" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                    {{ old('description', $fish->description ?? '') }}
                </textarea>
            </div>
        </div>

        <div class="flex justify-center gap-4 mt-10">
            <button type="submit" class="gradient-btn text-white font-semibold px-6 py-2 rounded-2xl shadow-md transition">
                {{ isset($fish) ? 'Simpan Perubahan' : 'Tambah Ikan' }}
            </button>

            <a href="{{ route('fishes.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-2xl shadow-md transition">
                Batal
            </a>
        </div>
    </div>
</div>

