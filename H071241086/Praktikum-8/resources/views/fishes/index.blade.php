@extends('layouts.app')
@section('title', 'Daftar Ikan')

@section('content')
<form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-6 
  bg-white/40 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/30">
  
  <div class="col-span-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama ikan..."
           class="w-full rounded-lg border border-sky-300 bg-white/70 focus:ring-4 focus:ring-sky-300 focus:outline-none px-3 py-2 font-semibold placeholder-gray-400 shadow-inner">
  </div>

  <div>
    <select name="rarity" class="w-full rounded-lg border border-cyan-300 bg-white/70 focus:ring-4 focus:ring-cyan-300 px-3 py-2 font-semibold shadow-inner">
      <option value="">Semua Rarity</option>
      @foreach($rarities as $r)
        <option value="{{ $r }}" {{ request('rarity')==$r ? 'selected' : '' }}>{{ $r }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <select name="sort_by" class="w-full rounded-lg border border-teal-300 bg-white/70 focus:ring-4 focus:ring-teal-300 px-3 py-2 font-semibold shadow-inner">
      <option value="">Urutkan Berdasarkan</option>
      <option value="name" {{ request('sort_by')=='name' ? 'selected' : '' }}>Nama</option>
      <option value="sell_price_per_kg" {{ request('sort_by')=='sell_price_per_kg' ? 'selected' : '' }}>Harga per Kg</option>
      <option value="catch_probability" {{ request('sort_by')=='catch_probability' ? 'selected' : '' }}>Peluang Tangkap</option>
    </select>
  </div>

  <div>
    <select name="dir" class="w-full rounded-lg border border-blue-300 bg-white/70 focus:ring-4 focus:ring-blue-300 px-3 py-2 font-semibold shadow-inner">
      <option value="asc" {{ request('dir')=='asc' ? 'selected' : '' }}>Naik (ASC)</option>
      <option value="desc" {{ request('dir')=='desc' ? 'selected' : '' }}>Turun (DESC)</option>
    </select>
  </div>

  <div class="flex gap-2">
    <button class="bg-gradient-to-r from-cyan-400 to-blue-400 hover:from-cyan-500 hover:to-blue-500 text-white font-bold px-4 py-2 rounded-lg w-full shadow-md transition transform hover:scale-105">
      Terapkan
    </button>
    <a href="{{ route('fishes.index') }}" 
       class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2 rounded-lg w-full text-center shadow-md transition transform hover:scale-105">
       🔄
    </a>
  </div>
</form>

<div class="overflow-x-auto bg-white rounded-2xl shadow-2xl">
  <table class="min-w-full divide-y divide-gray-200 text-sm font-semibold">
    <thead class="bg-gradient-to-r from-sky-200 via-cyan-100 to-sky-200">
      <tr class="text-gray-900 text-center uppercase tracking-wide">
        <th class="py-3 px-2 font-bold">ID</th>
        <th class="py-3 px-2 font-bold">Nama</th>
        <th class="py-3 px-2 font-bold">Rarity</th>
        <th class="py-3 px-2 font-bold">Berat (kg)</th>
        <th class="py-3 px-2 font-bold">Harga/kg</th>
        <th class="py-3 px-2 font-bold">Peluang (%)</th>
        <th class="py-3 px-2 font-bold">Aksi</th>
      </tr>
    </thead>

    <tbody class="divide-y divide-gray-100 text-center bg-white/80 backdrop-blur-sm">
      @forelse($fishes as $fish)
      <tr class="hover:bg-cyan-50 transition transform hover:scale-[1.01]">
        <td class="py-2">{{ $fish->id }}</td>
        <td class="py-2 text-left px-2 font-bold text-gray-700">{{ $fish->name }}</td>
        <td class="py-2">
          <span class="
            px-2 py-1 rounded-full text-xs font-bold uppercase
            @switch($fish->rarity)
              @case('Common') bg-gray-200 text-gray-700 @break
              @case('Uncommon') bg-green-200 text-green-800 @break
              @case('Rare') bg-blue-200 text-blue-800 @break
              @case('Epic') bg-purple-200 text-purple-800 @break
              @case('Legendary') bg-yellow-200 text-yellow-800 @break
              @case('Mythic') bg-pink-200 text-pink-800 @break
              @case('Secret') bg-red-200 text-red-800 @break
            @endswitch
          ">
            {{ $fish->rarity }}
          </span>
        </td>
        <td>{{ $fish->weight_range }}</td>
        <td>{{ $fish->formatted_price }}</td>
        <td>{{ $fish->catch_probability }}%</td>
        <td>
          <div class="flex justify-center gap-2">
            <a href="{{ route('fishes.show',$fish) }}"
               class="bg-gradient-to-r from-sky-300 to-cyan-400 hover:from-sky-400 hover:to-cyan-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md transform hover:scale-105 transition">
               Lihat
            </a>

            <a href="{{ route('fishes.edit',$fish) }}"
               class="bg-gradient-to-r from-yellow-300 to-amber-400 hover:from-yellow-400 hover:to-amber-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md transform hover:scale-105 transition">
               Edit
            </a>

            <form action="{{ route('fishes.destroy',$fish) }}" method="POST" onsubmit="return confirm('Yakin mau hapus ikan ini?')">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="bg-gradient-to-r from-pink-300 to-rose-400 hover:from-pink-400 hover:to-rose-500 text-white px-3 py-1 rounded-lg text-xs font-bold shadow-md transform hover:scale-105 transition">
                      Hapus
              </button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" class="text-center text-gray-500 py-6 text-lg font-bold">Belum ada ikan yang ditambahkan</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-6 flex justify-center">
  {{ $fishes->links() }}
</div>
@endsection