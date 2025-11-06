@extends('layouts.app')
@section('title', 'Detail Ikan')

@section('content')
<div class="min-h-screen py-10 px-6 flex justify-center items-center bg-cover bg-center"
     style="background-image: url('{{ asset('images/fish-bg.jpg') }}');">

  <div class="max-w-4xl w-full p-10">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-4xl font-extrabold text-sky-800 tracking-wider drop-shadow-md">
        Detail Ikan: <span class="text-cyan-600">{{ $fish->name }}</span>
      </h2>
      <a href="{{ route('fishes.index') }}" 
         class="bg-cyan-100 hover:bg-cyan-400 text-gray-900 font-bold px-5 py-3 rounded-lg shadow-lg border-2 border-cyan-500 transform hover:scale-105 transition-all">
         Kembali
      </a>
    </div>

    <div class="rounded-2xl border border-white/40 p-8 bg-white/30 backdrop-blur-md shadow-lg transition-all">
      <table class="w-full text-left text-lg text-gray-900">
        <tbody class="divide-y divide-sky-200/50">
          <tr>
            <th class="py-3 w-1/3 font-extrabold text-sky-800 uppercase">Nama Ikan</th>
            <td class="py-3">{{ $fish->name }}</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Rarity</th>
            <td class="py-3">
              <span class="
                px-3 py-1.5 rounded-lg text-sm font-bold uppercase tracking-wide border-2 shadow
                @switch($fish->rarity)
                  @case('Common') bg-gray-200 text-gray-700 border-gray-400 @break
                  @case('Uncommon') bg-green-200 text-green-800 border-green-500 @break
                  @case('Rare') bg-blue-200 text-blue-800 border-blue-500 @break
                  @case('Epic') bg-purple-200 text-purple-800 border-purple-500 @break
                  @case('Legendary') bg-yellow-200 text-yellow-800 border-yellow-500 @break
                  @case('Mythic') bg-pink-200 text-pink-800 border-pink-500 @break
                  @case('Secret') bg-red-200 text-red-800 border-red-500 @break
                @endswitch
              ">
                {{ $fish->rarity }}
              </span>
            </td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Berat Minimum</th>
            <td class="py-3">{{ number_format($fish->base_weight_min, 2) }} kg</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Berat Maksimum</th>
            <td class="py-3">{{ number_format($fish->base_weight_max, 2) }} kg</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Rentang Berat</th>
            <td class="py-3">{{ $fish->weight_range }}</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Harga per Kg</th>
            <td class="py-3 text-teal-700 font-extrabold text-2xl">
              {{ $fish->formatted_price }}
            </td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Peluang Tertangkap</th>
            <td class="py-3">{{ $fish->catch_probability }}%</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Deskripsi</th>
            <td class="py-3 italic">{{ $fish->description ?: '-' }}</td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Waktu Dibuat</th>
            <td class="py-3">
              {{ $fish->created_at ? $fish->created_at->timezone('Asia/Makassar')->format('d F Y, H:i') : '-' }}
            </td>
          </tr>
          <tr>
            <th class="py-3 font-extrabold text-sky-800 uppercase">Terakhir Diperbarui</th>
            <td class="py-3">
              {{ $fish->created_at ? $fish->updated_at->timezone('Asia/Makassar')->format('d F Y, H:i') : '-' }}

          </tr>
        </tbody>
      </table>

      <div class="mt-10 flex justify-end gap-5">
        <a href="{{ route('fishes.edit', $fish) }}"
           class="bg-yellow-300 hover:bg-yellow-500 text-gray-900 font-bold px-6 py-3 rounded-lg shadow-md border-2 border-yellow-500 transform hover:scale-105 transition-all">
          Edit
        </a>

        <form action="{{ route('fishes.destroy', $fish) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus ikan ini?')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="bg-pink-300 hover:bg-pink-500 text-gray-900 font-bold px-6 py-3 rounded-lg shadow-md border-2 border-pink-500 transform hover:scale-105 transition-all">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection