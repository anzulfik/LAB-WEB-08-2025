<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Produk')</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col">
        
        <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a href="#" class="text-2xl font-bold text-indigo-600">TP 9</a>
                    </div>
                    
                    <nav class="hidden md:flex space-x-8">
                        
                        {{-- Link Kategori --}}
                        <a href="{{ route('categories.index') }}" 
                           class="font-medium transition duration-150
                           {{ request()->is('categories*') 
                                ? 'text-indigo-600 border-b-2 border-indigo-500' 
                                : 'text-gray-500 hover:text-gray-900' }}">
                           Kategori
                        </a>
                        
                        {{-- Link Gudang (Warehouse) --}}
                        <a href="{{ route('warehouses.index') }}"
                           class="font-medium transition duration-150
                           {{ request()->is('warehouses*') 
                                ? 'text-indigo-600 border-b-2 border-indigo-500' 
                                : 'text-gray-500 hover:text-gray-900' }}">
                           Gudang
                        </a>
                        
                        {{-- Link Produk --}}
                        <a href="{{ route('products.index') }}"
                           class="font-medium transition duration-150
                           {{ request()->is('products*') 
                                ? 'text-indigo-600 border-b-2 border-indigo-500' 
                                : 'text-gray-500 hover:text-gray-900' }}">
                           Produk
                        </a>

                        {{-- Link Stok --}}
                        <a href="{{ route('stock.index') }}"
                           class="font-medium transition duration-150
                           {{ request()->is('stock*') 
                                ? 'text-indigo-600 border-b-2 border-indigo-500' 
                                : 'text-gray-500 hover:text-gray-900' }}">
                           Manajemen Stok
                        </a>
                    </nav>
                </div>
            </div>
        </header>
        <main class="flex-grow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                
                {{-- Pesan Sukses (jika ada) --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                

                {{-- Error Validasi (jika ada) --}}

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                        <strong class="font-bold">Oops! Ada kesalahan:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-800">
                            @yield('title')
                        </h1>
                    </div>
                    <div class="p-6">
                        @yield('content')
                    </div>
                </div>

            </div>
        </main>

        <footer class="bg-white border-t border-gray-200 mt-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-sm text-gray-500">
                Tugas 9 - Sistem Manajemen Produk &copy; {{ date('Y') }}
            </div>
        </footer>
    </div>

</body>
</html>