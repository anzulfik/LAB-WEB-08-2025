<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terminal — Product System</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        mono: ['Share Tech Mono', 'monospace']
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-[#05010a] text-cyan-300 font-mono min-h-screen flex flex-col relative overflow-hidden">

<!-- Cyberpunk Background -->
<div class="fixed inset-0 z-0">
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 via-pink-500/5 to-purple-500/10"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(0,255,255,0.08),transparent_60%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_80%,rgba(255,0,255,0.08),transparent_60%)]"></div>
</div>

<!-- NAVIGATION -->
<header class="relative z-50 border-b border-cyan-400/30 bg-black/40 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Brand -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-pink-500 rounded shadow-[0_0_15px_rgba(0,255,255,0.6)]"></div>
            <span class="tracking-widest text-lg text-cyan-300 group-hover:text-pink-400 transition">
                DATA TERMINAL
            </span>
        </a>

        <!-- Menu -->
        <nav>
            <ul class="flex gap-6 text-sm tracking-wider">
                @php
                    $menu = [
                        ['route' => 'categories.index', 'label' => 'CATEGORIES'],
                        ['route' => 'warehouses.index', 'label' => 'WAREHOUSES'],
                        ['route' => 'products.index', 'label' => 'PRODUCTS'],
                        ['route' => 'stocks.index', 'label' => 'STOCKS'],
                    ];
                @endphp

                @foreach($menu as $item)
                    <li>
                        <a href="{{ route($item['route']) }}"
                           class="relative px-3 py-2 border border-cyan-400/30 rounded
                           hover:bg-cyan-400/10 hover:shadow-[0_0_10px_rgba(0,255,255,0.5)]
                           transition-all duration-300
                           {{ request()->routeIs(str_replace('.index','.*',$item['route'])) ? 'text-pink-400 border-pink-400' : '' }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="relative z-10 grow px-6 py-12">
    <div class="max-w-7xl mx-auto">
        @yield('content')
    </div>
</main>

<!-- FOOTER -->
<footer class="relative z-10 border-t border-cyan-400/20 bg-black/40 backdrop-blur-md py-4 text-center text-xs tracking-widest">
    <p class="text-cyan-400/70 animate-pulse">
        &copy; 2025 — PRODUCT DATA TERMINAL SYSTEM
    </p>
</footer>

@yield('scripts')

</body>
</html>
