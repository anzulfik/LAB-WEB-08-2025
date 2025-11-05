@extends('layouts.master')

@section('title', 'Destinasi')

@section('content')
    <div class="relative min-h-screen -mt-28 flex flex-col items-center">
        <div class="absolute inset-0 bg-cover bg-center -z-10" style="background-image: url('{{ asset('images/awan.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/kalelawar.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/awan-tp.png') }}');">
        </div>
        
        <h1 class="text-5xl text-gray-800 mt-36 tracking-wide relative -left-[420px]">
            Destinasi Populer
        </h1>
        
        <div class="w-full max-w-7xl mt-7 px-4 flex justify-center space-x-8 tracking-wider">
            <div class="w-1/3 bg-white/60 backdrop-blur-md rounded-3xl overflow-hidden shadow-xl p-4 text-center transform hover:scale-[1.02] transition duration-300">
                <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white mb-4">
                    <img src="{{ asset('images/mattabulu.png') }}" alt="Gambar Mattabulu" class="w-full h-48 object-cover">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2 ">
                    Mattabulu
                </h2>
                <p class="text-gray-600 text-sm">
                    Tempat sempurna untuk bersantai dan menikmati keindahan alam Soppeng dari ketinggian.
                </p>
            </div>
            <div class="w-1/3 bg-white/60 backdrop-blur-md rounded-3xl overflow-hidden shadow-xl p-4 text-center transform hover:scale-[1.02] transition duration-300">
                <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white mb-4">
                    <img src="{{ asset('images/liu-pangie.png') }}" alt="Gambar Liu Pangi'e" class="w-full h-48 object-cover">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Liu Pangi'e
                </h2>
                <p class="text-gray-600 text-sm">
                    Air terjun alami dengan suasana tenang dan air jernih di tengah pepohonan rimbun.
                </p>
            </div>
            <div class="w-1/3 bg-white/60 backdrop-blur-md rounded-3xl overflow-hidden shadow-xl p-4 text-center transform hover:scale-[1.02] transition duration-300">
                <div class="rounded-2xl overflow-hidden shadow-lg border-2 border-white mb-4">
                    <img src="{{ asset('images/lejja.png') }}" alt="Gambar Lejja" class="w-full h-48 object-cover">
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    Lejja
                </h2>
                <p class="text-gray-600 text-sm">
                    Sumber air panas alami di perbukitan Soppeng, terkenal akan khasiatnya.
                </p>
            </div>
            </div>
        
    </div>
@endsection