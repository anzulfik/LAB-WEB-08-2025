{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Daftar Kategori Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-700">Daftar Kategori Produk</h2>
    <a href="{{ route('categories.create') }}"
       class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
        + Tambah Kategori
    </a>
</div>

{{-- Pesan sukses --}}
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 shadow-sm">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Card berisi tabel --}}
<div class="card overflow-x-auto">
    <table class="w-full text-sm text-gray-700">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="py-3 px-4 text-left font-semibold">No</th>
                <th class="py-3 px-4 text-left font-semibold">Nama Kategori</th>
                <th class="py-3 px-4 text-left font-semibold">Deskripsi</th>
                <th class="py-3 px-4 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $c)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4">{{ $loop->iteration }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $c->name }}</td>
                    <td class="py-3 px-4 text-gray-600">{{ $c->description ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-3">

                            {{-- Tombol Detail --}}
                            <a href="{{ route('categories.show', $c->id) }}"
                               class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-md text-sm font-medium">
                                🔍 Detail
                            </a>

                            {{-- Tombol Edit --}}
                            <a href="{{ route('categories.edit', $c->id) }}"
                               class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-md text-sm font-medium">
                                ✏️ Edit
                            </a>

                            {{-- Tombol Hapus (MODAL) --}}
                            <button type="button"
                                    onclick="confirmDelete('{{ route('categories.destroy', $c->id) }}')"
                                    class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1 rounded-md text-sm font-medium">
                                🗑️ Hapus
                            </button>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $categories->links('pagination::tailwind') }}
</div>
@endsection

{{-- ===== MODAL HAPUS (SAMA PERSIS DENGAN WAREHOUSE & PRODUCTS) ===== --}}
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Kategori?</h3>
        <p class="text-sm text-gray-500 mb-5">Data kategori akan dihapus permanen. Lanjutkan?</p>

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
