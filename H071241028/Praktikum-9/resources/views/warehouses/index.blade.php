{{-- resources/views/warehouses/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Gudang')
@section('page_title', 'Manajemen Gudang')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h2 class="text-xl font-semibold text-gray-700">Daftar Gudang</h2>

        <a href="{{ route('warehouses.create') }}"
           class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">
            + Tambah Gudang
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Pencarian --}}
    <div class="flex justify-between items-center">
        <input type="text" id="searchWarehouse"
               placeholder="Cari gudang berdasarkan nama atau lokasi..."
               class="w-full md:w-1/3 border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-rose-500"
        >
    </div>

    {{-- Tabel Gudang --}}
    <div class="card overflow-x-auto">
        <table class="w-full text-sm text-gray-700" id="warehouseTable">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="py-3 px-4 text-left font-semibold">No</th>
                    <th class="py-3 px-4 text-left font-semibold">Nama Gudang</th>
                    <th class="py-3 px-4 text-left font-semibold">Lokasi</th>
                    <th class="py-3 px-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($warehouses as $w)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $w->name }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $w->location ?? '-' }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('warehouses.edit', $w->id) }}"
                                   class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1 rounded-md text-sm font-medium">
                                   ✏️ Edit
                                </a>
                                <a href="{{ route('warehouses.show', $w->id) }}"
                                   class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-md text-sm font-medium">
                                   👁️ Lihat
                                </a>
                                <button type="button"
                                        onclick="confirmDelete('{{ route('warehouses.destroy', $w->id) }}')"
                                        class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1 rounded-md text-sm font-medium">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data gudang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $warehouses->links('pagination::tailwind') }}
    </div>
</div>

{{-- Modal konfirmasi hapus --}}
<div id="deleteModal"
     class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Hapus Gudang?</h3>
        <p class="text-sm text-gray-500 mb-5">Data gudang akan dihapus permanen. Lanjutkan?</p>
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
    const searchInput = document.getElementById('searchWarehouse');
    const rows = document.querySelectorAll('#warehouseTable tbody tr');

    searchInput?.addEventListener('keyup', function () {
        const query = this.value.toLowerCase();
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');

    function confirmDelete(url) {
        form.action = url;
        modal.classList.remove('hidden');
    }
    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
