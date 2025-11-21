{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Produk')
@section('page_title', 'Daftar Produk')

@section('content')
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <h2 class="text-xl font-semibold text-gray-700">Daftar Produk</h2>
    <a href="{{ route('products.create') }}"
       class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
        + Tambah Produk
    </a>
</div>

{{-- Pesan sukses --}}
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 shadow-sm">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Form pencarian dan filter --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4 md:items-end">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500"
                   placeholder="Ketik nama produk...">
        </div>

        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Filter Kategori</label>
            <select name="category_id"
                    class="w-full border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit"
                class="bg-rose-600 hover:bg-rose-700 text-white px-5 py-2 rounded-lg shadow transition">
            🔍 Cari
        </button>
    </form>
</div>

{{-- Tabel Produk --}}
<div class="card overflow-x-auto">
    <table class="w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="py-3 px-4 text-left font-semibold">No</th>
                <th class="py-3 px-4 text-left font-semibold">Nama Produk</th>
                <th class="py-3 px-4 text-left font-semibold">Kategori</th>
                <th class="py-3 px-4 text-left font-semibold">Harga</th>
                <th class="py-3 px-4 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $p)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $p->name }}</td>
                    <td class="py-3 px-4">
                        @if($p->category)
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">
                                {{ $p->category->name }}
                            </span>
                        @else
                            <span class="text-gray-500 text-sm">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 font-semibold text-rose-600">
                        Rp{{ number_format($p->price, 0, ',', '.') }}
                    </td>

                    {{-- Aksi --}}
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-3">

                            {{-- Detail --}}
                            <a href="{{ route('products.show', $p->id) }}"
                               class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-md text-sm font-medium">
                                🔍 Detail
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('products.edit', $p->id) }}"
                               class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-md text-sm font-medium">
                                ✏️ Edit
                            </a>

                            {{-- Hapus (modal seperti warehouse) --}}
                            <button type="button"
                                    onclick="confirmDelete('{{ route('products.destroy', $p->id) }}')"
                                    class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1 rounded-md text-sm font-medium">
                                🗑️ Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-4 text-center text-gray-500">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $products->links('pagination::tailwind') }}
</div>

@endsection


{{-- MODAL DELETE — sama persis seperti warehouse --}}
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Produk?</h3>
        <p class="text-sm text-gray-500 mb-5">Data produk akan dihapus permanen. Lanjutkan?</p>

        <div class="flex justify-center gap-3">
            <button onclick="closeModal()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                Batal
            </button>

            <form id="deleteForm" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');

    function confirmDelete(url) {
        form.action = url;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
