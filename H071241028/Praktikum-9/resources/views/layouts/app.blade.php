<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Produk')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" href="https://laravel.com/img/favicon/favicon-32x32.png" type="image/png">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            background-color: #1b1f3b;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            color: #cfd8e3;
            border-radius: 8px;
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #e11d48;
            color: #fff;
        }

        /* Card & Scrollbar */
        .card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 14px rgba(0,0,0,0.08);
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.15);
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-[#f5f6fa] text-gray-800 flex min-h-screen">

        {{-- Sidebar (fixed di kiri) --}}
        <aside id="sidebar"
            class="sidebar fixed top-0 left-0 h-full w-64 p-6 flex flex-col justify-between z-50 shadow-lg">
            <div>
                <div class="flex items-center mb-10 space-x-3">
                    <img src="{{ asset('images/logo.png') }}" 
                        alt="Logo" 
                        class="h-12 w-12 object-contain drop-shadow-md">
                    <h1 class="text-2xl font-extrabold text-white tracking-wide">
                        Product<span class="text-rose-400">App</span>
                    </h1>
                </div>

                <nav class="space-y-1">
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">🏠 Dashboard</a>
                    <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">📦 Kategori</a>
                    <a href="{{ route('warehouses.index') }}" class="{{ request()->routeIs('warehouses.*') ? 'active' : '' }}">🏭 Gudang</a>
                    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">🛒 Produk</a>
                    <a href="{{ route('stocks.index') }}" class="{{ request()->routeIs('stocks.*') ? 'active' : '' }}">📊 Stok</a>
                </nav>
            </div>

            <footer class="text-center text-xs text-gray-400 mt-8 border-t border-slate-800 pt-4">
                <p>© {{ date('Y') }} Laravel</p>
                <p>Dibuat oleh {{ Auth::user()->name ?? 'Princess Azzahra' }}</p>
            </footer>
        </aside>

        {{-- Overlay untuk sidebar di mobile --}}
        <div id="overlay"
            class="fixed inset-0 bg-black bg-opacity-40 hidden md:hidden z-40"></div>

    {{-- Konten utama --}}
    <main class="flex-1 flex flex-col min-h-screen md:pl-64 transition-all duration-300">

        {{-- Navbar atas --}}
        <header class="flex justify-between items-center px-6 py-4 bg-white shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-3">
                {{-- Tombol toggle sidebar (mobile) --}}
                <button id="menuToggle"
                        class="md:hidden text-2xl text-gray-700 focus:outline-none">☰</button>
                <h2 class="text-xl md:text-2xl font-semibold text-gray-700">
                    @yield('page_title', 'Dashboard')
                </h2>
            </div>

            {{-- Kanan navbar --}}
            <div class="flex items-center gap-4 relative">
                <form action="{{ route('dashboard.search') }}" method="GET" class="flex items-center">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari produk, kategori, gudang, stok..."
                        class="border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-rose-500 focus:outline-none transition w-44 md:w-64"
                        required>
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-2 rounded-r-lg">
                        🔍
                    </button>
                </form>     
                {{-- Dropdown user --}}
                <div class="relative">
                    <button id="userMenuBtn"
                            class="flex items-center gap-2 focus:outline-none">
                        <span class="hidden sm:inline font-medium text-gray-700">
                            {{ Auth::user()->name ?? 'Guest' }}
                        </span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=e11d48&color=fff"
                             class="w-8 h-8 rounded-full border-2 border-gray-200">
                    </button>

                    <div id="userMenu"
                         class="hidden absolute right-0 mt-2 w-44 bg-white shadow-lg rounded-lg py-2 border border-gray-100">
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profil</a>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Pengaturan</a>
                        <a href="#" class="block px-4 py-2 text-rose-600 hover:bg-rose-100">Keluar</a>
                    </div>
                </div>
            </div>
        </header>

        {{-- Isi konten --}}
        <section class="p-6 md:p-8 flex-1 overflow-y-auto bg-[#f5f6fa]">
            <div class="w-full space-y-6">
                @yield('content')
            </div>
        </section>
    </main>

    {{-- Script interaktif --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');
        const overlay = document.getElementById('overlay');
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');

        // Sidebar toggle (mobile)
        menuToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });
        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Dropdown profil
        userMenuBtn?.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', (e) => {
            if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
