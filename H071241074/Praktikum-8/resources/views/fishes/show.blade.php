@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto mt-20">
    {{-- <img src="{{ asset('images/hiasan-ikan-tabel-index.png') }}" alt="Hiasan ikan tabel" class="absolute left-[350px] top-15 w-[800px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index2.png') }}" alt="Hiasan ikan tabel" class="absolute left-96 top-56 w-[800px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index3.png') }}" alt="Hiasan ikan tabel" class="absolute right-[330px] top-12 w-[800px] object-cover pointer-events-none z-40"/>
    <img src="{{ asset('images/hiasan-ikan-tabel-index4.png') }}" alt="Hiasan ikan tabel" class="absolute left-[350px] top-44 w-[800px] object-cover pointer-events-none z-40"/> --}}
    <div class="relative glass-container p-8">
        <a href="{{ route('fishes.index') }}" 
           class="absolute top-4 left-4 text-gray-700 hover:text-[#2a5f68]font-semibold transition text-2xl leading-none">
            &lt;
        </a>

        <h2 class="text-3xl font-bold text-[#2a5f68] mb-6 text-center">
            Detail Ikan <br> {{ $fish->name }}
        </h2>

        <div class="overflow-hidden rounded-xl bg-white/40 backdrop-blur-md border border-white/40">
            <table class="w-full text-left border-collapse">
                <tbody class="divide-y divide-gray-200/60">
                    <tr><td class="py-3 px-4 font-semibold text-gray-700 w-1/3">Rarity</td><td class="py-3 px-4 text-gray-900">{{ $fish->rarity }}</td></tr>
                    <tr><td class="py-3 px-4 font-semibold text-gray-700">Berat</td><td class="py-3 px-4 text-gray-900">{{ $fish->formatted_weight_range }}</td></tr>
                    <tr><td class="py-3 px-4 font-semibold text-gray-700">Harga</td><td class="py-3 px-4 text-gray-900">{{ $fish->formatted_price }}</td></tr>
                    <tr><td class="py-3 px-4 font-semibold text-gray-700">Peluang</td><td class="py-3 px-4 text-gray-900">{{ $fish->catch_probability }}%</td></tr>
                    <tr><td class="py-3 px-4 font-semibold text-gray-700">Deskripsi</td><td class="py-3 px-4 text-gray-900">{{ $fish->description ?? '-' }}</td></tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center gap-4 mt-8">
            <a href="{{ route('fishes.edit', $fish) }}" 
               class="gradient-btn text-white font-semibold px-5 py-2 rounded-2xl shadow-md transition">
               Edit
            </a>

            <button type="button"
                    onclick="confirmDelete('{{ route('fishes.destroy', $fish) }}')"
                    class="gradient-red text-white font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                Hapus
            </button>
        </div>
    </div>
</div>

<div id="deleteModal" class="fixed inset-0 hidden justify-center items-center modal-bg z-50">
    <div class="bg-white/60 backdrop-blur-md rounded-xl p-6 shadow-xl text-center max-w-sm mx-auto">
        <p class="text-lg font-semibold text-gray-800 mb-5">Yakin ingin menghapus ikan ini?</p>
        <div class="flex justify-center gap-4">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="gradient-red text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
                    Ya, Hapus
                </button>
            </form>
            <button onclick="closeModal()" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2 rounded-2xl shadow-md transition">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
function confirmDelete(url) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}
function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
