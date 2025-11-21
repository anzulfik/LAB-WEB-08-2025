<form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST" class="space-y-6 text-gray-800">
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Kategori</label>
        <select name="category_id" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" 
                    {{ old('category_id', $product->category_id ?? '') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Harga</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">{{ old('description', $product->detail->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Berat (kg)</label>
        <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->detail->weight ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1 text-gray-700">Ukuran</label>
        <input type="text" name="size" value="{{ old('size', $product->detail->size ?? '') }}" class="w-full px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
    </div>

    <div class="flex justify-center gap-4 mt-10">
        <button type="submit" class="gradient-btn text-white font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            {{ isset($product) ? 'Perbarui' : 'Simpan' }}
        </button>

        <a href="{{ route('products.index') }}" 
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-6 py-2 rounded-2xl shadow-md transition">
            Batal
        </a>
    </div>
</form>
