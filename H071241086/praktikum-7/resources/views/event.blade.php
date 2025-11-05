@extends('layouts.master')
@section('title', 'Event Lokal - Eksplor Bulukumba')

@section('content')
<div class="relative min-h-[60vh] flex flex-col justify-center items-center text-center">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/bg.jpg') }}" 
             alt="Cover Bulukumba" 
             class="w-full h-full object-cover brightness-75 transition duration-700 hover:brightness-90">
        <div class="absolute inset-0 bg-gradient-to-b from-teal-900/70 via-teal-800/60 to-teal-700/70"></div>
    </div>

    <div class="relative z-10 px-6 py-10 max-w-3xl">
        <h1 class="text-white text-4xl md:text-5xl font-extrabold drop-shadow-lg mb-3 tracking-tight">
            EVENT BULUKUMBA
        </h1>
        <p class="text-white/90 text-base md:text-lg leading-relaxed max-w-2xl mx-auto">
            Bulukumba memiliki berbagai acara budaya dan festival wisata yang menarik setiap tahun. 
            Berikut beberapa di antaranya:
        </p>
    </div>
</div>

<div class="relative z-10 bg-gradient-to-b from-white via-teal-50 to-teal-100 py-12 px-6">
    <div class="max-w-5xl mx-auto space-y-10">

        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white rounded-3xl p-3 shadow-2xl md:w-72 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/pinisi_festival.jpg') }}" alt="Festival Pinisi" class="w-full h-48 object-cover rounded-2xl">
            </div>
            <div class="bg-gradient-to-r from-teal-800 to-teal-700 rounded-2xl p-6 shadow-xl flex-1 border border-white/30">
                <h3 class="text-white text-xl font-extrabold uppercase tracking-wide mb-2">
                    Festival Pinisi
                </h3>
                <p class="text-white/90 leading-relaxed">
                    Perayaan tahunan untuk menghormati warisan pembuatan kapal Pinisi oleh masyarakat Bulukumba.
                    Biasanya diadakan di Pantai Bira dengan parade laut, lomba perahu, dan pertunjukan budaya.
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white rounded-3xl p-3 shadow-2xl md:w-72 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/ammatoa_festival.jpg') }}" alt="Festival Adat Ammatoa" class="w-full h-48 object-cover rounded-2xl">
            </div>
            <div class="bg-gradient-to-r from-teal-800 to-teal-700 rounded-2xl p-6 shadow-xl flex-1 border border-white/30">
                <h3 class="text-white text-xl font-extrabold uppercase tracking-wide mb-2">
                    Adat Ammatoa Kajang
                </h3>
                <p class="text-white/90 leading-relaxed">
                    Festival adat di kawasan Kajang yang menampilkan ritual adat, musik tradisional, dan nilai-nilai
                    kesederhanaan masyarakat Ammatoa.
                </p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white rounded-3xl p-3 shadow-2xl md:w-72 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/expo_kreatif.jpg') }}" alt="Expo Kreatif" class="w-full h-48 object-cover rounded-2xl">
            </div>
            <div class="bg-gradient-to-r from-teal-800 to-teal-700 rounded-2xl p-6 shadow-xl flex-1 border border-white/30">
                <h3 class="text-white text-xl font-extrabold uppercase tracking-wide mb-2">
                    Expo Kreatif
                </h3>
                <p class="text-white/90 leading-relaxed">
                    Festival yang menampilkan berbagai produk kreatif lokal, mulai dari kerajinan tangan hingga kuliner khas Bulukumba.
                </p>
            </div>
        </div>

        <div class="bg-teal-800/80 backdrop-blur-md rounded-3xl p-6 border border-white/30 shadow-lg text-center">
            <p class="text-white text-base md:text-lg leading-relaxed">
                Event-event ini tidak hanya menjadi daya tarik wisata, tetapi juga 
                <span class="font-extrabold text-yellow-300">memperkuat identitas budaya</span> masyarakat Bulukumba.
            </p>
        </div>

    </div>
</div>
@endsection