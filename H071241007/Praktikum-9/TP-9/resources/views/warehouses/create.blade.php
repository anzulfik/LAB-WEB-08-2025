@extends('layouts.app')

@section('title', 'Tambah Gudang Baru')

@section('content')
    <form action="{{ route('warehouses.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            {{-- Nama Gudang --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Gudang </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- lokasi --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700">Lokasi </label>
                <textarea name="location" id="location" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('location') border-red-500 @enderror">{{ old('location') }}</textarea>
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-3 mt-6 border-t border-gray-200 pt-4">
            <a href="{{ route('warehouses.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                Simpan
            </button>
        </div>
    </form>
@endsection