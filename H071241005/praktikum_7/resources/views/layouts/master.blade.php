<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Tana Toraja')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <header class="group top-0 left-0 w-full z-50 transition-all duration-300 @yield('header-classes', 'sticky bg-white shadow-md') hover:bg-white">
        <nav class="container mx-auto px-6 h-20 flex justify-between items-center">
            
            <div>
                <a href="{{ url('/') }}" class="flex items-center space-x-4">
                    
                    <img src="{{ asset('images/logo.png') }}" alt="Eksplor Tana Toraja Logo" class="h-12 w-auto">
                    
                    <span class="text-2xl font-bold @yield('header-title-color', 'text-gray-900') group-hover:text-gray-900">
                        Eksplor Tana Toraja
                    </span>
                </a>
            </div>


            <div class="space-x-6">
                <a href="{{ url('/') }}" class="font-medium @yield('header-nav-color', 'text-gray-600 hover:text-blue-600') group-hover:text-gray-600 group-hover:hover:text-blue-600">Home</a>
                <a href="{{ url('/destinasi') }}" class="font-medium @yield('header-nav-color', 'text-gray-600 hover:text-blue-600') group-hover:text-gray-600 group-hover:hover:text-blue-600">Destinasi</a>
                <a href="{{ url('/kuliner') }}" class="font-medium @yield('header-nav-color', 'text-gray-600 hover:text-blue-600') group-hover:text-gray-600 group-hover:hover:text-blue-600">Kuliner</a>
                <a href="{{ url('/galeri') }}" class="font-medium @yield('header-nav-color', 'text-gray-600 hover:text-blue-600') group-hover:text-gray-600 group-hover:hover:text-blue-600">Galeri</a>
                <a href="{{ url('/kontak') }}" class="font-medium @yield('header-nav-color', 'text-gray-600 hover:text-blue-600') group-hover:text-gray-600 group-hover:hover:text-blue-600">Kontak</a>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white py-10 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Eksplor Tana Toraja. Kevin Anugrah Somakila.</p>
        </div>
    </footer>

</body>
</html>