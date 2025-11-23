<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Fish-Net // Aliran Data</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Roboto Mono untuk semua elemen */
        body, input, select, button, textarea {
            font-family: 'Roboto Mono', monospace;
        }
        /* Efek glow pada elemen-elemen tertentu */
        .neon-glow {
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5), 0 0 10px rgba(59, 130, 246, 0.3);
        }
        .neon-text {
            text-shadow: 0 0 8px rgba(59, 130, 246, 0.7);
        }
        /* Background Aurora */
        .aurora-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-color: #0d1117; /* Warna dasar gelap */
            opacity: 0.5;
            background-image:
                radial-gradient(at 27% 37%, hsla(215, 98%, 61%, 0.1) 0px, transparent 50%),
                radial-gradient(at 97% 21%, hsla(125, 98%, 72%, 0.1) 0px, transparent 50%),
                radial-gradient(at 52% 99%, hsla(355, 98%, 61%, 0.1) 0px, transparent 50%),
                radial-gradient(at 10% 29%, hsla(256, 96%, 61%, 0.15) 0px, transparent 50%),
                radial-gradient(at 97% 96%, hsla(38, 60%, 74%, 0.1) 0px, transparent 50%),
                radial-gradient(at 33% 50%, hsla(222, 67%, 73%, 0.1) 0px, transparent 50%),
                radial-gradient(at 79% 53%, hsla(343, 68%, 73%, 0.1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-[#0d1117] text-gray-300">
    <div class="aurora-bg"></div>

    <header class="sticky top-0 z-10 bg-black/30 backdrop-blur-md border-b border-blue-500/30">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('ikan.index') }}" class="text-xl font-bold text-blue-400 neon-text tracking-widest">
                        [//] FISH-NET
                    </a>
                </div>
                <div>
                    <a href="{{ route('ikan.create') }}" class="inline-flex items-center px-4 py-2 border border-blue-500 text-sm font-medium rounded-md text-blue-400 bg-blue-500/10 hover:bg-blue-500/20 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-blue-500">
                        + REGISTRASI SPESIMEN
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-10">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

</body>
</html>