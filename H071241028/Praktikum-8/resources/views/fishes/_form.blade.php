@csrf
<div class="space-y-5">

  {{-- Nama Ikan --}}
  <div>
    <label class="block text-lg font-semibold text-white/90 mb-2">Nama Ikan</label>
    <input type="text" name="name"
      value="{{ old('name',$fish->name??'') }}"
      class="w-full px-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/50
             focus:ring-2 focus:ring-sky-400 outline-none backdrop-blur-md"
      placeholder="Contoh: Tuna Biru"
      required>
  </div>

  {{-- Rarity --}}
  <div>
    <label class="block text-lg font-semibold text-white/90 mb-2">Rarity</label>
    <select name="rarity"
      class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
             focus:ring-2 focus:ring-sky-400 outline-none"
      required>
      @foreach($rarities as $r)
        <option value="{{ $r }}" {{ old('rarity',$fish->rarity??'')==$r?'selected':'' }}>{{ $r }}</option>
      @endforeach
    </select>
  </div>

  {{-- Berat --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div>
      <label class="block text-lg font-semibold text-white/90 mb-2">Berat Minimum (kg)</label>
      <input type="number" step="0.01" name="base_weight_min"
        value="{{ old('base_weight_min',$fish->base_weight_min??'') }}"
        class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
               focus:ring-2 focus:ring-sky-400 outline-none"
        placeholder="cth: 1.25" required>
    </div>
    <div>
      <label class="block text-lg font-semibold text-white/90 mb-2">Berat Maksimum (kg)</label>
      <input type="number" step="0.01" name="base_weight_max"
        value="{{ old('base_weight_max',$fish->base_weight_max??'') }}"
        class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
               focus:ring-2 focus:ring-sky-400 outline-none"
        placeholder="cth: 8.75" required>
    </div>
  </div>

  {{-- Harga --}}
  <div>
    <label class="block text-lg font-semibold text-white/90 mb-2">Harga per Kg (💰 Coins)</label>
    <input type="number" name="sell_price_per_kg"
      value="{{ old('sell_price_per_kg',$fish->sell_price_per_kg??'') }}"
      class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
             focus:ring-2 focus:ring-sky-400 outline-none"
      placeholder="cth: 5000" required>
  </div>

  {{-- Peluang --}}
  <div>
    <label class="block text-lg font-semibold text-white/90 mb-2">Peluang Tertangkap (%)</label>
    <input type="number" step="0.01" name="catch_probability"
      value="{{ old('catch_probability',$fish->catch_probability??'') }}"
      class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
             focus:ring-2 focus:ring-sky-400 outline-none"
      placeholder="cth: 25.50"
      required>
  </div>

  {{-- Deskripsi --}}
  <div>
    <label class="block text-lg font-semibold text-white/90 mb-2">Deskripsi</label>
    <textarea name="description" rows="3"
      class="w-full px-4 py-3 rounded-xl bg-white/20 text-white backdrop-blur-md
             focus:ring-2 focus:ring-sky-400 outline-none"
      placeholder="Tuliskan deskripsi ikan...">{{ old('description',$fish->description??'') }}</textarea>
  </div>

  {{-- Tombol --}}
  <div class="flex justify-center gap-4 mt-6">
    <button type="submit"
      class="px-8 py-3 bg-gradient-to-r from-sky-500 to-blue-600 rounded-xl font-bold text-white shadow-lg
             hover:from-sky-400 hover:to-blue-500 transition-all duration-300 transform hover:scale-105">
      💾 Simpan Ikan
    </button>
    <a href="{{ route('fishes.index') }}"
      class="px-8 py-3 bg-white/20 border border-white/30 text-white rounded-xl shadow-md
             hover:bg-white/30 backdrop-blur-sm transition-all duration-300">
      ⬅ Kembali
    </a>
  </div>

</div>
