<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Eksplor Batam') - Pariwisata Batam</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
</head>
<body id="page-@yield('page-id', 'default')">

    @if(trim($__env->yieldContent('page-id')) != 'landing')
        <nav class="dest-nav">
            <div class="dest-nav-logo">
                <img src="{{ asset('images/logo_batam.png') }}" alt="Logo Banten">
            </div>
            
            <div class="nav-icons-right"> 
                <div class="dest-nav-home">
                    <a href="/" title="Kembali ke Home">
                        <i class="fa-solid fa-house"></i>
                    </a>
                </div>

                <div class="hamburger-menu">
                    <i class="fa-solid fa-bars hamburger-icon"></i>
                    <div class="dropdown-menu">
                        <a href="{{ route('destinasi') }}">Destinasi</a>
                        <a href="/kuliner">Kuliner</a>
                        <a href="/galeri">Galeri</a>
                        <a href="/kontak">Kontak</a>
                    </div>
                </div>
            </div> </nav>
    @endif
    <main class="@yield('main-class', 'content')">
        @yield('content')
    </main>

    @if(trim($__env->yieldContent('page-id')) != 'landing' && trim($__env->yieldContent('page-id')) != 'destination-page')
        <footer>
            <p>&copy; 2025 - Eksplor Pariwisata Nusantara - Batam</p>
        </footer>
    @endif

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
     
    @stack('scripts')

</body>
</html>