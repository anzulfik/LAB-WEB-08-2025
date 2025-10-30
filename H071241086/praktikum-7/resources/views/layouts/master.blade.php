<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Bulukumba')</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="flex flex-col min-h-screen bg-gradient-to-b from-white via-sky-50 to-cyan-50">

    <header class="bg-gradient-to-r from-cyan-700 via-blue-800 to-indigo-900 text-white shadow-2xl sticky top-0 z-50">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6 py-4">

            <div class="flex items-center space-x-3 mb-4 md:mb-0">
                <img src="{{ asset('images/logo.jpg') }}" 
                     alt="Logo Bulukumba" 
                     class="w-14 h-16 rounded-lg object-cover hover:scale-105 transition duration-300 shadow-md">
                <h1 class="text-2xl font-extrabold tracking-wide drop-shadow-md">
                    <a href="{{ route('home') }}" class="hover:text-yellow-300 transition duration-300">
                        Eksplor Bulukumba
                    </a>
                </h1>
            </div>

          <nav class="flex flex-wrap justify-center space-x-3 md:space-x-5 text-sm md:text-base font-semibold text-white text-center">
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Home</x-nav-link>
                <x-nav-link :href="route('destinasi')" :active="request()->routeIs('destinasi')">Destinasi</x-nav-link>
                <x-nav-link :href="route('kuliner')" :active="request()->routeIs('kuliner')">Kuliner</x-nav-link>
                <x-nav-link :href="route('event')" :active="request()->routeIs('event')">Event Lokal</x-nav-link>
                <x-nav-link :href="route('galeri')" :active="request()->routeIs('galeri')">Galeri</x-nav-link>
                <x-nav-link :href="route('peta')" :active="request()->routeIs('peta')">Peta Wisata</x-nav-link>
                <x-nav-link :href="route('kontak')" :active="request()->routeIs('kontak')">Kontak</x-nav-link>
            </nav>

        </div>
    </header>

    <main class="flex-1 container mx-auto px-6 py-10 animate-fadeIn">
        @yield('content')
    </main>

    <footer class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 text-gray-300 text-center py-8 mt-8 shadow-inner">
        <div class="container mx-auto px-6">
            <p class="text-sm md:text-base leading-relaxed">
                &copy; {{ date('Y') }} <span class="font-semibold text-white">Eksplor Bulukumba</span> 
                <span class="text-yellow-300 italic">"Butta Panrita Lopi" – Tanah Keindahan dan Kearifan Lokal</span>
            </p>
        </div>
    </footer>

</body>
</html>