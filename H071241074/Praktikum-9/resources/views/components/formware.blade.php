<form action="{{ isset($warehouse) ? route('warehouses.update', $warehouse) : route('warehouses.store') }}" 
      method="POST"
      class="space-y-6 text-gray-800">
    @csrf
    @if(isset($warehouse)) 
    @method('PUT') 
    @endif

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Gudang</label>
        <input type="text" name="name" value="{{ old('name', $warehouse->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Lokasi Gudang</label>
        <textarea name="location" rows="3" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">{{ old('location', $warehouse->location ?? '') }}</textarea>
    </div>

    <div class="flex justify-center gap-4 mt-10">
        <button type="submit" class="gradient-btn text-white font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            {{ isset($warehouse) ? 'Perbarui' : 'Simpan' }}
        </button>

        <a href="{{ route('warehouses.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            Batal
        </a>
    </div>
</form>
