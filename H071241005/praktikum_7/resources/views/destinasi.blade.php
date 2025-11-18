@extends('layouts.master')

@section('title', 'Destinasi - Eksplor Tana Toraja')

@section('content')
    <div class="relative h-96 bg-gray-800">
        <img src="{{ asset('images/destinasi_hero.jpg') }}" alt="Destinasi Tana Toraja" class="w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Destinasi Wisata</h1>
                <p class="text-lg md:text-xl max-w-2xl">Temukan tempat-tempat paling ikonik di Tana Toraja yang menyimpan sejuta cerita.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        
        <div class="grid md:grid-cols-3 gap-8">

            <x-card
                imgSrc="kete_kesu.jpg"
                tag="Budaya"
                title="Kete Kesu"
                description="Desa adat yang terkenal dengan deretan Tongkonan yang terawat baik dan kuburan tebing (liang) kuno. Menawarkan wawasan mendalam tentang kehidupan tradisional Toraja."
            />

            <x-card
                imgSrc="londa.jpg"
                tag="Sejarah"
                title="Londa"
                description="Situs pemakaman kuno di dalam gua alami. Pengunjung akan melihat peti mati (erong) dan patung kayu (Tau-tau) yang disimpan di tebing curam."
            />

            <x-card
                imgSrc="buntu_burake.jpg"
                tag="Religi"
                title="Patung Yesus Buntu Burake"
                description="Salah satu patung Yesus Kristus tertinggi di dunia. Berdiri megah di atas bukit, menawarkan pemandangan spektakuler kota Makale dan sekitarnya."
            />

        </div>
    </div>
@endsection