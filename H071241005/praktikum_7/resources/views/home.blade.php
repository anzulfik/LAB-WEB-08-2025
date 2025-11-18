@extends('layouts.master')

@section('title', 'Home - Eksplor Tana Toraja')

@section('header-classes', 'absolute')
@section('header-title-color', 'text-white')
@section('header-nav-color', 'text-white hover:text-gray-300')


@section('content')
    <div class="relative h-screen">
        <video class="absolute top-0 left-0 w-full h-full object-cover z-0" autoplay loop muted playsinline>
            <source src="{{ asset('videos/toraja_bg.mp4') }}" type="video/mp4">
        </video>
        
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 z-10"></div>
        
        <div class="relative z-20 flex flex-col items-center justify-center h-full text-white text-center px-4">
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-4 animate-fade-in-down">
                Pesona Keindahan Tana Toraja
            </h1>
            <p class="text-lg md:text-2xl max-w-3xl animate-fade-in-up">
                Jelajahi keunikan budaya, ritual kuno, dan keindahan alam yang memukau di Tanah Para Raja.
            </p>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full h-32  from-gray-100 to-transparent z-20"></div>
    </div>

    <div class="container mx-auto px-6 relative z-30">

        <div class="bg-gray-900 text-white rounded-xl shadow-2xl p-8 md:p-12 mb-20 mt-12">
            <div class="grid md:grid-cols-4 gap-8 items-center">
                <div class="md:col-span-1 text-center md:text-left">
                    <h3 class="text-sm uppercase font-semibold tracking-wider text-gray-400">Spotlight</h3>
                    <h2 class="text-4xl font-bold mt-2">Ciri Khas Toraja</h2>
                    <p class="mt-4 text-gray-300">
                        Temukan keunikan budaya melalui karakteristiknya yang menonjol.
                    </p>
                    <a href="#" class="inline-block mt-6 bg-white text-gray-900 font-bold py-2 px-5 rounded-lg hover:bg-gray-200 transition-colors">
                        Jelajahi Semua &rarr;
                    </a>
                </div>
                <div class="md:col-span-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-800 rounded-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ asset('images/ciri_khas_tongkonan.jpg') }}" alt="Tongkonan" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="font-semibold text-lg">Arsitektur Tongkonan</h4>
                                <p class="text-sm text-gray-400 mt-1">Rumah adat dengan atap menjulang yang menjadi pusat kehidupan sosial.</p>
                            </div>
                        </div>
                        <div class="bg-gray-800 rounded-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ asset('images/ciri_khas_tau_tau.jpg') }}" alt="Tau-tau" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="font-semibold text-lg">Patung Tau-tau</h4>
                                <p class="text-sm text-gray-400 mt-1">Representasi kayu dari mereka yang telah meninggal, menjaga dari alam baka.</p>
                            </div>
                        </div>
                        <div class="bg-gray-800 rounded-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ asset('images/ciri_khas_rambu_solo.jpg') }}" alt="Rambu Solo'" class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h4 class="font-semibold text-lg">Upacara Rambu Solo'</h4>
                                <p class="text-sm text-gray-400 mt-1">Ritual pemakaman megah sebagai penghormatan terakhir kepada leluhur.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-sm uppercase font-semibold tracking-wider text-gray-500">UPCOMING EVENT</h3>
                    <h2 class="text-4xl font-bold text-gray-800 mt-1">Acara yang Tidak Boleh Terlewatkan</h2>
                </div>
                <a href="#" class="border border-gray-800 text-gray-800 font-bold py-2 px-5 rounded-lg hover:bg-gray-800 hover:text-white transition-colors">
                    Jelajahi Semua Acara &rarr;
                </a>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden group">
                    <div class="relative">
                        <img src="{{ asset('images/acara_lovely_december.jpg') }}" alt="Lovely December" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold uppercase px-2 py-1 rounded">Arts & Culture</div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2">Lovely December di Toraja</h4>
                        <p class="text-sm text-gray-600">Festival budaya tahunan yang menampilkan berbagai seni, pertunjukan, dan kuliner khas Toraja.</p>
                        <p class="text-sm text-gray-500 mt-4"><span class="font-bold">Tanggal:</span> 01 - 31 Des 2025</p>
                        <p class="text-sm text-gray-500"><span class="font-bold">Lokasi:</span> Rantepao & Makale</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg overflow-hidden group">
                     <div class="relative">
                        <img src="{{ asset('images/acara_makale_carnival.jpg') }}" alt="Makale Carnival" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-red-600 text-white text-xs font-bold uppercase px-2 py-1 rounded">MICE</div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2">Makale Carnival</h4>
                        <p class="text-sm text-gray-600">Pawai budaya yang meriah di jantung kota Makale, menampilkan kostum-kostum kreatif dan unik.</p>
                        <p class="text-sm text-gray-500 mt-4"><span class="font-bold">Tanggal:</span> 20 Agu 2025</p>
                        <p class="text-sm text-gray-500"><span class="font-bold">Lokasi:</span> Kota Makale</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg overflow-hidden group">
                     <div class="relative">
                        <img src="{{ asset('images/acara_festival_kopi.jpg') }}" alt="Festival Kopi Toraja" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 bg-green-600 text-white text-xs font-bold uppercase px-2 py-1 rounded">Music</div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold mb-2">Festival Kopi Toraja</h4>
                        <p class="text-sm text-gray-600">Rayakan cita rasa Kopi Arabika Toraja yang mendunia dengan pameran, workshop, dan musik.</p>
                        <p class="text-sm text-gray-500 mt-4"><span class="font-bold">Tanggal:</span> 15 - 17 Nov 2025</p>
                        <p class="text-sm text-gray-500"><span class="font-bold">Lokasi:</span> Rantepao</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 1s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out 0.5s forwards;
            opacity: 0; /* Mulai dengan transparan */
        }
    </style>
@endsection