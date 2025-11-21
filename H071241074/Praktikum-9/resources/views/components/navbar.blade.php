<nav class="fixed bg-white/30 py-5 backdrop-blur-md max-w-6xl mx-auto rounded-full top-6 left-0 right-0  text-blue-700 shadow-md z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">Manajemen Produk</h1>
            <div class="flex gap-5 text-md font-semibold">
                <a href="{{ route('home') }}" class="hover:text-blue-800">Beranda</a>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-800">Kategori</a>
                <a href="{{ route('warehouses.index') }}" class="hover:text-blue-800">Gudang</a>
                <a href="{{ route('products.index') }}" class="hover:text-blue-800">Produk</a>
                <a href="{{ route('stocks.index') }}" class="hover:text-blue-800">Stok</a>
                <a href="{{ route('stocks.transfer') }}" class="hover:text-blue-800">Transfer</a>
            </div>
        </div>
</nav>