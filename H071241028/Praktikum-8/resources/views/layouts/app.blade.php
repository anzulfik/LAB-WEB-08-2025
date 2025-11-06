<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FishIt Simulator')</title>

    {{-- Font Orbitron --}}
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Efek Gelembung Air 🫧 */
        .bubble {
            position: fixed;
            bottom: -50px;
            background: rgba(173, 216, 230, 0.25);
            border-radius: 50%;
            animation: rise 12s infinite ease-in;
            pointer-events: none;
            z-index: 1;
            box-shadow: 0 0 10px rgba(173, 216, 230, 0.6);
        }

        @keyframes rise {
            0% {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
            100% {
                transform: translateY(-110vh) scale(0.7);
                opacity: 0;
            }
        }
    </style>
</head>

@php
    // Mapping background gambar untuk setiap halaman
    $bgImages = [
        'fishes.index' => '/images/ocean-day.jpeg',
        'fishes.create' => '/images/sunset-beach.jpeg',
        'fishes.edit' => '/images/night-sea.jpeg',
        'fishes.show' => '/images/deepsea.jpeg',
    ];
    $bg = $bgImages[Route::currentRouteName()] ?? '/images/ocean-day.jpeg';
@endphp

<body class="font-[Orbitron] text-white min-h-screen bg-cover bg-center bg-fixed relative overflow-y-auto"
      style="background-image: url('{{ $bg }}'); background-attachment: fixed;">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 w-full bg-black/30 backdrop-blur-[2px] px-10 py-4 flex justify-between items-center z-50 border-b border-cyan-400/20">
        <h1 class="flex items-center gap-4 text-3xl font-extrabold tracking-wider text-sky-300 drop-shadow-[0_0_12px_rgba(6,182,212,0.9)]">
            <img src="{{ asset('images/fishpink-icon.png') }}" 
                alt="FishIt Logo" 
                class="h-12 w-12 object-contain inline-block align-middle drop-shadow-[0_0_12px_rgba(255,192,203,0.8)] hover:scale-110 transition-transform duration-300">
            <span>FishIt Simulator</span>
        </h1>
        <div class="space-x-8 text-lg flex items-center">
            <a href="{{ route('fishes.index') }}" class="hover:text-sky-300 flex items-center gap-3 transition">
                <img src="{{ asset('images/hiu-icon.png') }}" 
                    alt="Daftar Ikan" 
                    class="h-8 w-8 md:h-9 md:w-9 object-contain drop-shadow-[0_0_8px_rgba(6,182,212,0.8)] hover:scale-110 transition-transform duration-300">
                <span>Daftar Ikan</span>
            </a>

            <a href="{{ route('fishes.create') }}" class="hover:text-sky-300 flex items-center gap-3 transition">
                <img src="{{ asset('images/sotong-icon.png') }}" 
                    alt="Tambah Ikan" 
                    class="h-8 w-8 md:h-9 md:w-9 object-contain drop-shadow-[0_0_8px_rgba(6,182,212,0.8)] hover:scale-110 transition-transform duration-300">
                <span>Tambah Ikan</span>
            </a>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <main class="pt-24 pb-20 relative z-10">
        @if(session('success'))
            <div class="max-w-4xl mx-auto bg-green-500/80 text-white text-center rounded-xl py-3 mb-4 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="max-w-4xl mx-auto bg-red-500/80 text-white text-center rounded-xl py-3 mb-4 shadow-md">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

        {{-- Tambahkan padding bawah agar footer/akhir halaman tidak terpotong --}}
        <div class="pb-32"></div>
    </main>

    {{-- GELEMBUNG AIR 🫧 --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const totalBubbles = 25;
            for (let i = 0; i < totalBubbles; i++) {
                const bubble = document.createElement("div");
                bubble.classList.add("bubble");
                document.body.appendChild(bubble);

                bubble.style.left = `${Math.random() * 100}%`;
                const size = Math.random() * 25 + 10;
                bubble.style.width = `${size}px`;
                bubble.style.height = `${size}px`;

                const duration = Math.random() * 10 + 6;
                const delay = Math.random() * 10;
                bubble.style.animationDuration = `${duration}s`;
                bubble.style.animationDelay = `${delay}s`;

                const alpha = Math.random() * 0.25 + 0.1;
                bubble.style.background = `rgba(173, 216, 230, ${alpha})`;
            }
        });
    </script>
</body>
</html>
