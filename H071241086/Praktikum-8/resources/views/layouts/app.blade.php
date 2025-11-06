<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Fish It Simulator')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes bounce-slow {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-4px); }
    }

    .bounce {
      animation: bounce-slow 2s infinite;
    }

    body {
      background-image: url('{{ asset('images/background-fish.jpg') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .bg-overlay {
      background: linear-gradient(to bottom right, rgba(173, 216, 230, 0.3), rgba(135, 206, 235, 0.2));
      min-height: 100vh;
    }

    .navbar-blur {
      background: rgba(135, 206, 250, 0.5); 
      backdrop-filter: blur(5px) saturate(160%);
      -webkit-backdrop-filter: blur(10px) saturate(160%);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      border: none;
    }

    .footer-blur {
      background: rgba(100, 181, 246, 0.45);
      backdrop-filter: blur(5px) saturate(140%);
      -webkit-backdrop-filter: blur(8px) saturate(140%);
      color: white;
      box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="text-gray-800 flex flex-col min-h-screen font-sans">
  <div class="bg-overlay flex flex-col min-h-screen">

    <nav class="navbar-blur shadow-lg mb-6">
      <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('fishes.index') }}" class="flex items-center gap-3 text-white font-extrabold text-2xl ">
          Sistem Manajemen Fish It Roblox
        </a>

        <div class="flex space-x-3">
          <a href="{{ route('fishes.create') }}"
            class="px-4 py-2 rounded-lg font-bold transition transform hover:scale-105 hover:brightness-110 shadow-md
            {{ request()->is('fishes/create') ? 'bg-yellow-200 text-blue-900' : 'bg-white text-sky-600' }}">
             Tambah Ikan
          </a>
        </div>
      </div>
    </nav>

    <main class="flex-grow max-w-6xl mx-auto px-6 mb-8 w-full">
      @if(session('success'))
        <div class="mb-4 bg-teal-50 border-l-4 border-teal-400 text-teal-800 rounded-lg px-4 py-3 shadow-md relative animate-pulse">
          {{ session('success') }}
          <button onclick="this.parentElement.remove()" class="absolute top-2 right-3 text-teal-700 hover:text-teal-900 text-xl">&times;</button>
        </div>
      @endif

      <div>
        @yield('content')
      </div>
    </main>

    <footer class="footer-blur text-center text-sm py-4 font-semibold">
      &copy; {{ date('Y') }} <span class="text-yellow-200 font-bold">Fish It Simulator</span> 
    </footer>
  </div>
</body>
</html>