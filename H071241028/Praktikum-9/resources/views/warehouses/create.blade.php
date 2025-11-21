@extends('layouts.app')

@section('title', 'Tambah Gudang')
@section('page_title', 'Tambah Gudang Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">Tambah Gudang Baru</h2>
        <a href="{{ route('warehouses.index') }}"
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
           ← Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="card p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-100 text-rose-700 px-4 py-2 rounded-lg mb-4 shadow-sm">
                ⚠️ Terdapat kesalahan dalam pengisian form.
                <ul class="list-disc list-inside mt-1 text-sm">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('warehouses.store') }}" method="POST" id="createWarehouseForm" class="space-y-5">
            @csrf

            {{-- Nama Gudang --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Gudang</label>
                <input type="text" id="name" name="name" required
                       class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                       placeholder="Contoh: Gudang Pusat Jakarta">
                <p id="nameError" class="text-sm text-rose-600 mt-1 hidden">Nama gudang wajib diisi.</p>
            </div>

            {{-- Lokasi --}}
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Gudang</label>
                <textarea id="location" name="location"
                          class="w-full border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                          placeholder="Contoh: Jl. Merdeka No. 12, Makassar"></textarea>
            </div>

            {{-- Tombol Simpan --}}
            <div class="flex justify-end gap-3 pt-3">
                <button type="reset"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                    Reset
                </button>

                <button type="submit" id="submitBtn"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-lg shadow transition">
                    💾 Simpan Gudang
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script validasi ringan --}}
<script>
    const form = document.getElementById('createWarehouseForm');
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('nameError');

    form.addEventListener('submit', (e) => {
        if (nameInput.value.trim() === '') {
            e.preventDefault();
            nameError.classList.remove('hidden');
            nameInput.classList.add('border-rose-500');
        } else {
            nameError.classList.add('hidden');
            nameInput.classList.remove('border-rose-500');
        }
    });
</script>
@endsection
