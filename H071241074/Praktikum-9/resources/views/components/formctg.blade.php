<form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST" class="space-y-6 text-gray-800">
    @csrf
    @if(isset($category)) @method('PUT') 
    @endif
    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <div class="flex justify-center gap-4 mt-10">
        <button type="submit" class="gradient-btn text-white font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            {{ isset($category) ? 'Perbarui' : 'Simpan' }}
        </button>

        <a href="{{ route('categories.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            Batal
        </a>
    </div>
</form>
