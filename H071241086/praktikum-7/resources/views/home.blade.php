@extends('layouts.master')
@section('title', 'Home - Eksplor Bulukumba')
@section('content')
<div class="relative w-full h-screen bg-cover bg-center flex items-center justify-center overflow-hidden" 
     style="background-image: url('{{ asset('images/bira.jpg') }}');">

    <div class="absolute inset-0 bg-black/60"></div>

    <div class="absolute left-2 md:left-8 top-1/3 flex flex-col gap-3 md:gap-5 z-10">
        <img src="{{ asset('images/pinisi_festival.jpg') }}" 
             class="w-20 h-16 sm:w-28 sm:h-20 md:w-32 md:h-24 lg:w-36 lg:h-28 object-cover rounded-xl border-2 border-white shadow-xl transform -rotate-6 hover:rotate-0 transition duration-500">
        <img src="{{ asset('images/apparalang.jpg') }}" 
             class="w-20 h-16 sm:w-28 sm:h-20 md:w-32 md:h-24 lg:w-36 lg:h-28 object-cover rounded-xl border-2 border-white shadow-xl transform rotate-6 hover:rotate-0 transition duration-500">
    </div>

    <div class="absolute right-2 md:right-8 top-1/3 flex flex-col gap-3 md:gap-5 z-10">
        <img src="{{ asset('images/ammatoa.jpg') }}" 
             class="w-20 h-16 sm:w-28 sm:h-20 md:w-32 md:h-24 lg:w-36 lg:h-28 object-cover rounded-xl border-2 border-white shadow-xl transform rotate-6 hover:rotate-0 transition duration-500">
        <img src="{{ asset('images/barobbo.jpg') }}" 
             class="w-20 h-16 sm:w-28 sm:h-20 md:w-32 md:h-24 lg:w-36 lg:h-28 object-cover rounded-xl border-2 border-white shadow-xl transform -rotate-6 hover:rotate-0 transition duration-500">
    </div>

    <div class="relative text-center text-white max-w-[90%] sm:max-w-lg md:max-w-2xl lg:max-w-3xl px-4 sm:px-6 z-20 animate-fadeIn">
        <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-wide mb-2 drop-shadow-lg">
            WELCOME TO BULUKUMBA
        </h1>
        <h2 class="text-lg sm:text-2xl md:text-3xl lg:text-4xl text-orange-400 italic mb-5"
            style="font-family: 'Great Vibes', cursive;">
            Surga di Nusantara
        </h2>

        <p class="bg-black/60 p-3 sm:p-4 md:p-5 lg:p-6 rounded-xl text-xs sm:text-sm md:text-base lg:text-lg leading-relaxed shadow-lg">
            Bulukumba dikenal sebagai <strong>“Butta Panrita Lopi”</strong>, tanah para pembuat perahu Pinisi.
            Terletak di ujung selatan Sulawesi Selatan, Bulukumba menyuguhkan panorama pantai yang menawan,
            budaya adat <strong>Ammatoa Kajang</strong> yang unik, dan kuliner yang menggugah selera.
        </p>

        <div class="mt-5 md:mt-7">
            <span class="bg-white text-cyan-900 px-4 py-2 sm:px-5 sm:py-2.5 md:px-7 md:py-3 lg:px-8 lg:py-4 rounded-full font-semibold shadow-lg tracking-widest hover:bg-yellow-300 hover:text-black transition duration-300 text-[10px] sm:text-xs md:text-sm lg:text-base">
                DESTINASI • KULINER • EVENT FESTIVAL
            </span>
        </div>
    </div>
</div
@endsection