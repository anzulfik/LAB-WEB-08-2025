<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('images/logo-soppeng.png') }}">
    <style>
        @font-face {
            font-family: 'Coolvetica'; 
            src: url('/fonts/Coolvetica-Rg.otf') format('opentype');
            font-style: normal;
        }
    </style>
</head>
<body class=" text-gray-800 flex flex-col min-h-screen" style="font-family: 'Coolvetica', sans-serif;">
    {{-- <x-navbar /> --}}
    @include('components.navbar')

    <main id="page-content" class="pt-28 pb-10 transition-opacity duration-500 ease-in-out">
        @yield('content')
    </main>

    {{-- <x-footer /> --}}
    @include('components.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navBar = document.querySelectorAll('.navbar');
        const contentContainer = document.getElementById('page-content');
        let currentPath = window.location.pathname;

        if (currentPath.length > 1 && currentPath.endsWith('/')) {
            currentPath = currentPath.slice(0, -1);
        }
        if (currentPath === '') {
            currentPath = '/';
        }
        
        navBar.forEach(link => {
            const linkHref = link.getAttribute('href');

            if (linkHref === currentPath) {
                link.classList.add('bg-white/50', 'shadow-md', 'text-black');
                link.classList.remove('hover:bg-white/30', 'hover:text-black'); 
            } else {
                link.classList.remove('bg-white/50', 'shadow-md', 'text-black'); 
                link.classList.add('hover:bg-white/30', 'hover:text-black'); 
            }

            link.addEventListener('click', function(e) {
                const targetUrl = link.getAttribute('href');
                
                if (targetUrl === currentPath) return; 
                e.preventDefault(); 
                
                if (contentContainer) {
                    contentContainer.classList.add('opacity-0');
                    setTimeout(() => {
                        window.location.href = targetUrl; 
                    }, 500); 
                } else {
                    window.location.href = targetUrl;
                }
            });
        });
    });
</script>
</body>
</html>
