@extends('layouts.master')

@section('title', 'Galeri - Eksplor Tana Toraja')

@section('content')
    <div class="relative h-96 bg-gray-800">
        <img src="{{ asset('images/galeri_hero.jpg') }}" alt="Galeri Tana Toraja" class="w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Galeri Foto</h1>
                <p class="text-lg md:text-xl max-w-2xl">Keindahan budaya, alam, dan arsitektur ikonik Tana Toraja.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6"> @php $imgClass = "w-full h-64 object-cover rounded-lg shadow-md transition-all duration-300 hover:scale-105 hover:shadow-xl"; @endphp

         
            <img class="{{ $imgClass }}" src="{{ asset('images/ciri_khas_tongkonan.jpg') }}" alt="Tongkonan">
            <img class="{{ $imgClass }}" src="{{ asset('images/ciri_khas_rambu_solo.jpg') }}" alt="Upacara Rambu Solo">
            <img class="{{ $imgClass }}" src="{{ asset('images/ciri_khas_tau_tau.jpg') }}" alt="Tau Tau">
            <img class="{{ $imgClass }}" src="{{ asset('images/galeri_sawah.jpg') }}" alt="Sawah di Toraja">
            <img class="{{ $imgClass }}" src="{{ asset('images/londa.jpg') }}" alt="Kubur Batu">
            <img class="{{ $imgClass }}" src="{{ asset('images/galeri_tenun.jpg') }}" alt="Tenun Toraja">
            <img class="{{ $imgClass }}" src="{{ asset('images/galeri_kerbau.jpg') }}" alt="Kerbau Belang (Tedong Bonga)">
            <img class="{{ $imgClass }}" src="{{ asset('images/galeri_pemandangan.jpg') }}" alt="Pemandangan Alam Toraja">
            <img class="{{ $imgClass }}" src="{{ asset('images/galeri_ollon.jpg') }}" alt="Pemandangan Alam Toraja">

        </div>
    </div>
@endsection