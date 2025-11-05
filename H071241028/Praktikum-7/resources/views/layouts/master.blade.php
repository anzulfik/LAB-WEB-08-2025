<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Yogyakarta')</title>
    <script src="https://cdn.tailwindcss.com?plugins=typography,forms,aspect-ratio,line-clamp"></script>
</head>

<body class="font-sans bg-stone-100 text-stone-900 min-h-screen flex flex-col antialiased">

    {{-- HEADER/NAVBAR --}}
    <header class="bg-stone-900 shadow-xl sticky top-0 z-50 border-b-4 border-stone-800">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">

            {{-- Logo / Judul Web --}}
            <h1 class="text-2xl font-extrabold text-stone-100 flex items-center gap-2 tracking-wider hover:text-white transition duration-300">
                <span class="text-3xl"></span>Eksplor Yogyakarta
            </h1>

            {{-- Tombol Menu Mobile --}}
            <button 
                id="menu-btn" 
                class="md:hidden text-stone-100 hover:text-white focus:outline-none p-1"
                aria-label="Toggle Menu">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Navigasi Desktop --}}
            <nav class="hidden md:flex gap-8 text-stone-300 font-medium tracking-wide">
                <a href="/" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Home</a>
                <a href="/tentang" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Tentang</a>
                <a href="/destinasi" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Destinasi</a>
                <a href="/kuliner" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Kuliner</a>
                <a href="/event" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Event</a>
                <a href="/galeri" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Galeri</a>
                <a href="/kontak" class="hover:text-white transition hover:shadow-sm hover:shadow-stone-100/30">Kontak</a>
            </nav>
        </div>

        {{-- Navigasi Mobile --}}
        <nav 
            id="mobile-menu" 
            class="hidden md:hidden bg-stone-800 text-stone-100 font-medium text-center space-y-2 py-3 border-t border-stone-700">
            <a href="{{ route('home') }}" class="block py-2 hover:bg-stone-700/50">Home</a>
            <a href="{{ route('tentang') }}" class="block py-2 hover:bg-stone-700/50">Tentang</a>
            <a href="{{ route('destinasi') }}" class="block py-2 hover:bg-stone-700/50">Destinasi</a>
            <a href="{{ route('kuliner') }}" class="block py-2 hover:bg-stone-700/50">Kuliner</a>
            <a href="{{ route('event') }}" class="block py-2 hover:bg-stone-700/50">Event</a>
            <a href="{{ route('galeri') }}" class="block py-2 hover:bg-stone-700/50">Galeri</a>
            <a href="{{ route('kontak') }}" class="block py-2 hover:bg-stone-700/50">Kontak</a>
        </nav>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="flex-grow">
        <div class="container mx-auto px-6 py-12"> 
            @yield('content') 
        </div>
    </main>
    
    {{-- FOOTER --}}
    <footer class="bg-stone-900 text-center text-stone-300 py-6 mt-auto border-t-4 border-stone-800">
        <p class="font-light text-sm">
            © 2025 Eksplor Yogyakkarta
        </p>
        <p class="text-xs mt-1 text-stone-400">
            By Azzahra
        </p>
    </footer>

    {{-- Mobile Menu Script (Dipertahankan di sini, atau bisa dipindahkan ke app.js) --}}
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    
</body>
</html>