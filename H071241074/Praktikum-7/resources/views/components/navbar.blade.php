<header class="bg-black/20 backdrop-blur-md fixed max-w-6xl w-full mx-auto z-50 top-6 left-0 right-0 rounded-full shadow-2xl">
    <div class="container mx-auto flex justify-between items-center px-6 py-3"> 
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-soppeng.png') }}" alt="Logo Soppeng" class="w-7"> 
            <img src="{{ asset('images/logo-sulsel.png') }}" alt="Logo Sulsel" class="w-12"> 
            <span class=" text-gray-800 text-lg tracking-wider">#AyoKeSoppeng</span> 
        </div>

        <nav id="navbar" class="flex gap-1 text-gray-800 tracking-wider"> 
            <a href="{{ route('home') }}" class="navbar px-5 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Home</a>
            <a href="/destinasi" class="navbar px-4 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Destinasi</a>
            <a href="/kuliner" class="navbar px-4 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Kuliner</a>
            <a href="/peta" class="navbar px-4 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Peta</a>
            <a href="/galeri" class="navbar px-4 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Galeri</a>
            <a href="/kontak" class="navbar px-4 py-2 rounded-full transition duration-150 hover:bg-white/30 hover:text-gray-800">Kontak</a>
        </nav>
    </div>
</header>