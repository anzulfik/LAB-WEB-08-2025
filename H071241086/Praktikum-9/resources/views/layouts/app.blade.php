<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Manajemen Produk' }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes glow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1042 50%, #0d1b3a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Neon curved lines background */
        .neon-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .neon-curve {
            position: absolute;
            border: 3px solid;
            border-radius: 50%;
            filter: blur(2px);
            animation: glow 3s ease-in-out infinite;
        }

        /* Top left curves */
        .curve-1 {
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            border-color: #00f0ff;
            box-shadow: 0 0 20px #00f0ff, 0 0 40px #00f0ff;
        }

        .curve-2 {
            top: -80px;
            left: -80px;
            width: 260px;
            height: 260px;
            border-color: #ff00ff;
            box-shadow: 0 0 20px #ff00ff, 0 0 40px #ff00ff;
            animation-delay: 1s;
        }

        .curve-3 {
            top: -60px;
            left: -60px;
            width: 220px;
            height: 220px;
            border-color: #8000ff;
            box-shadow: 0 0 20px #8000ff, 0 0 40px #8000ff;
            animation-delay: 2s;
        }

        /* Bottom right curves */
        .curve-4 {
            bottom: -150px;
            right: -150px;
            width: 400px;
            height: 400px;
            border-color: #00f0ff;
            box-shadow: 0 0 30px #00f0ff, 0 0 60px #00f0ff;
            animation-delay: 0.5s;
        }

        .curve-5 {
            bottom: -120px;
            right: -120px;
            width: 340px;
            height: 340px;
            border-color: #ff00ff;
            box-shadow: 0 0 30px #ff00ff, 0 0 60px #ff00ff;
            animation-delay: 1.5s;
        }

        .curve-6 {
            bottom: -90px;
            right: -90px;
            width: 280px;
            height: 280px;
            border-color: #8000ff;
            box-shadow: 0 0 30px #8000ff, 0 0 60px #8000ff;
            animation-delay: 2.5s;
        }

        /* Wavy line connector */
        .wave-line {
            position: absolute;
            top: 50%;
            left: 10%;
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, #00f0ff 0%, #ff00ff 100%);
            box-shadow: 0 0 10px #00f0ff, 0 0 20px #ff00ff;
            transform: translateY(-50%);
            border-radius: 50px;
        }

        /* Navbar styling */
        nav {
            background: rgba(10, 14, 39, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid rgba(0, 240, 255, 0.3);
            box-shadow: 0 4px 30px rgba(0, 240, 255, 0.2);
            position: relative;
            z-index: 10;
        }

        nav a {
            position: relative;
            transition: all 0.3s ease;
        }

        nav a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00f0ff, #ff00ff);
            transition: width 0.3s ease;
            box-shadow: 0 0 10px #00f0ff;
        }

        nav a:hover::after {
            width: 100%;
        }

        nav a:hover {
            color: #00f0ff;
            text-shadow: 0 0 10px #00f0ff;
        }

        .logo-text {
            background: linear-gradient(90deg, #00f0ff, #ff00ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: bold;
            text-shadow: 0 0 20px rgba(0, 240, 255, 0.5);
        }

        /* Content wrapper */
        .content-wrapper {
            position: relative;
            z-index: 5;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        /* Floating particles */
        .particle {
            position: fixed;
            width: 4px;
            height: 4px;
            background: #00f0ff;
            border-radius: 50%;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 0 10px #00f0ff;
            z-index: 1;
        }

        .particle:nth-child(2) {
            background: #ff00ff;
            box-shadow: 0 0 10px #ff00ff;
            animation-delay: 2s;
        }

        .particle:nth-child(3) {
            background: #8000ff;
            box-shadow: 0 0 10px #8000ff;
            animation-delay: 4s;
        }
    </style>
</head>

<body>
    <!-- Neon Background -->
    <div class="neon-bg">
        <div class="neon-curve curve-1"></div>
        <div class="neon-curve curve-2"></div>
        <div class="neon-curve curve-3"></div>
        <div class="neon-curve curve-4"></div>
        <div class="neon-curve curve-5"></div>
        <div class="neon-curve curve-6"></div>
        <div class="wave-line"></div>
    </div>

    <!-- Floating Particles -->
    <div class="particle" style="top: 20%; left: 15%;"></div>
    <div class="particle" style="top: 60%; left: 80%;"></div>
    <div class="particle" style="top: 40%; left: 50%;"></div>

    <!-- NAVBAR -->
    <nav class="text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <a href="{{ url('/') }}" class="text-2xl font-bold logo-text">
                Manajemen Produk
            </a>

            <ul class="flex space-x-8 text-sm font-medium">

                <li>
                    <a href="{{ route('categories.index') }}"
                       class="hover:text-cyan-400 transition">
                       Kategori
                    </a>
                </li>

                <li>
                    <a href="{{ route('warehouses.index') }}"
                       class="hover:text-cyan-400 transition">
                       Warehouse
                    </a>
                </li>

                <li>
                    <a href="{{ route('products.index') }}"
                       class="hover:text-cyan-400 transition">
                       Produk
                    </a>
                </li>

                <li>
                    <a href="{{ route('stocks.index') }}"
                       class="hover:text-cyan-400 transition">
                       Stok
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <div class="max-w-7xl mx-auto mt-8 px-4 pb-8">
        <div class="content-wrapper p-8 text-white">
            @yield('content')
        </div>
    </div>

</body>
</html>