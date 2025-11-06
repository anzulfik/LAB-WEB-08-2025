@extends('layouts.app')
@section('title', 'Edit Ikan')

@section('content')
<div class="min-h-screen py-10 px-6 flex justify-center items-center bg-cover bg-center backdrop-blur-sm"
     style="background-image: url('{{ asset('images/fish-bg.jpg') }}');">

  <div class="max-w-3xl w-full bg-white/40 backdrop-blur-md border border-white/30 shadow-2xl rounded-2xl p-8 transition-all transform hover:scale-[1.01]">

    <h2 class="text-4xl font-extrabold text-sky-800 mb-6 drop-shadow-md tracking-wide text-center">
      Edit Data Ikan
    </h2>

    <form method="POST" action="{{ route('fishes.update', $fish) }}" class="space-y-6">
      @csrf
      @method('PUT')
      <div>
        <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Nama Ikan</label>
        <input type="text" name="name" value="{{ old('name', $fish->name) }}"
          class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                 {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
        @error('name')
          <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Rarity</label>
        <select name="rarity"
          class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                 {{ $errors->has('rarity') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
          @foreach($rarities as $r)
            <option value="{{ $r }}" {{ old('rarity', $fish->rarity)==$r ? 'selected' : '' }}>{{ $r }}</option>
          @endforeach
        </select>
        @error('rarity')
          <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Berat Minimum (kg)</label>
          <input type="number" step="0.01" name="base_weight_min"
            value="{{ old('base_weight_min', $fish->base_weight_min) }}"
            class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                   {{ $errors->has('base_weight_min') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
          @error('base_weight_min')
            <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Berat Maksimum (kg)</label>
          <input type="number" step="0.01" name="base_weight_max"
            value="{{ old('base_weight_max', $fish->base_weight_max) }}"
            class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                   {{ $errors->has('base_weight_max') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
          @error('base_weight_max')
            <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div>
        <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Harga per Kg</label>
        <input type="number" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}"
          class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                 {{ $errors->has('sell_price_per_kg') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
        @error('sell_price_per_kg')
          <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Peluang Tertangkap (%)</label>
        <input type="number" step="0.01" name="catch_probability"
          value="{{ old('catch_probability', $fish->catch_probability) }}"
          class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                 {{ $errors->has('catch_probability') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">
        @error('catch_probability')
          <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-sky-800 font-extrabold mb-1 uppercase tracking-wide">Deskripsi</label>
        <textarea name="description" rows="4"
          class="w-full border-2 rounded-lg px-4 py-3 bg-white/70 text-gray-800 font-semibold focus:ring-4 focus:ring-sky-300 focus:outline-none transition-all
                 {{ $errors->has('description') ? 'border-red-500 bg-red-50' : 'border-sky-400 hover:border-cyan-500' }}">{{ old('description', $fish->description) }}</textarea>
        @error('description')
          <p class="text-red-600 text-sm mt-1 font-medium">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-between pt-6">
        <a href="{{ route('fishes.index') }}"
           class="bg-cyan-100 hover:bg-cyan-400 border-2 border-cyan-500 text-gray-900 font-extrabold px-6 py-3 rounded-lg shadow-lg transform hover:scale-105 transition-all">
           ⬅ Kembali
        </a>
        <button type="submit"
                class="bg-yellow-200 hover:bg-yellow-400 border-2 border-yellow-500 text-gray-900 font-extrabold px-6 py-3 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                Simpan Perubahan
        </button>
      </div>

    </form>
  </div>
</div>
@endsection