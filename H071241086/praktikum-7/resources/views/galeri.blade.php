@extends('layouts.master')
@section('title', 'Galeri - Eksplor Bulukumba')

@section('content')
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 py-16 sm:py-20 md:py-24 px-4 sm:px-8 md:px-20 min-h-screen overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-transparent to-cyan-900/40 pointer-events-none"></div>
    
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-20 left-10 sm:left-20 w-60 sm:w-80 md:w-96 h-60 sm:h-80 md:h-96 bg-cyan-500/30 rounded-full mix-blend-screen filter blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 sm:right-40 w-56 sm:w-72 md:w-80 h-56 sm:h-72 md:h-80 bg-blue-500/30 rounded-full mix-blend-screen filter blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full mix-blend-screen filter blur-3xl"></div>
        <div class="absolute top-40 right-20 w-64 h-64 bg-teal-500/25 rounded-full mix-blend-screen filter blur-3xl animate-pulse"></div>
    </div>

    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative z-10 max-w-[1600px] mx-auto text-center mb-10 sm:mb-16">        
        <h1 class="text-5xl sm:text-7xl md:text-8xl font-black mb-6 sm:mb-8 leading-none tracking-tight">
            <span class="block bg-gradient-to-r from-white via-cyan-100 to-blue-200 bg-clip-text text-transparent drop-shadow-[0_4px_10px_rgba(0,255,255,0.5)]">
                Galeri Bulukumba
            </span>
        </h1>
        
        <p class="text-lg md:text-xl text-blue-100/80 max-w-2xl mx-auto">
            Kumpulan momen indah dari destinasi wisata, kuliner khas, dan event menarik di Bulukumba
        </p>
    </div>

   
        {{-- $rows = [
            array_slice($galeri, 0, 4),
            array_slice($galeri, 4, 4),
            array_slice($galeri, 8, 4),
            array_slice($galeri, 12, 2),
        ];
    @endphp --}}

    <div class="flex flex-col items-center sm:items-start -space-y-10 sm:-space-y-14 md:-space-y-16">
        @foreach ($rows as $rowIndex => $row)
            <div class="flex flex-wrap justify-center sm:justify-start gap-4 sm:gap-6 md:gap-0 {{ $rowIndex % 2 != 0 ? 'sm:ml-[60px] md:ml-[110px]' : '' }}">
                @foreach ($row as $item) 
                <div class="relative group w-36 h-40 sm:w-48 sm:h-52 md:w-[220px] md:h-[240px]">
                    <div class="absolute inset-0 overflow-hidden" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);">
                       <div class="absolute inset-0 overflow-hidden transition-transform duration-700 group-hover:scale-105" 
                            style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); transform-origin: center;">
                            <img src="{{ asset($item[0]) }}" alt="{{ $item[1] }}" class="w-full h-full object-cover brightness-110">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-br from-{{ $item[3] }}-900/50 via-teal-900/50 to-blue-900/50 opacity-20 group-hover:opacity-60 transition-opacity duration-500"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center p-2 text-center opacity-0 group-hover:opacity-100 transition-all duration-500">
                            <div class="bg-white/20 backdrop-blur-sm px-2 py-1 rounded-full mb-1 border border-white/30">
                                <span class="text-white text-xs font-bold tracking-wide">{{ $item[2] }}</span>
                            </div>
                            <h3 class="text-white font-black text-[10px] sm:text-xs leading-tight drop-shadow-2xl">{{ $item[1] }}</h3>
                        </div>
                    </div>
                    <div class="absolute inset-0 border-2 border-white/30 group-hover:border-{{ $item[3] }}-400 transition-all duration-500" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);"></div>
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-sm bg-{{ $item[3] }}-400/50" style="clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);"></div>
                </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-slate-950/80 to-transparent pointer-events-none"></div>

</section>
@endsection