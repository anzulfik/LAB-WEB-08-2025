@extends('layouts.master')
@section('title', 'Destinasi - Eksplor Bulukumba')

@section('content')

<div class="relative -mt-8 -mx-4 sm:-mx-6 lg:-mx-8 mb-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600">
        <div class="absolute top-0 left-0 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-20 right-0 w-[500px] h-[500px] bg-cyan-400/40 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s; animation-duration: 4s;"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-blue-400/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s; animation-duration: 5s;"></div>
    </div>

    <div class="relative z-10 text-center py-12 sm:py-16 px-4">
        <div class="mb-6">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white mb-3 leading-none tracking-tight" style="text-shadow: 6px 6px 12px rgba(0,0,0,0.4);">
                Destinasi Wisata
            </h1>
            
            <div class="flex items-center justify-center gap-3 my-4">
                <div class="h-0.5 w-12 sm:w-16 bg-gradient-to-r from-transparent to-white/60 rounded-full"></div>
                <div class="w-2 h-2 bg-white/80 rounded-full animate-pulse"></div>
                <div class="w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse" style="animation-delay: 0.2s;"></div>
                <div class="w-1.5 h-1.5 bg-white/60 rounded-full animate-pulse" style="animation-delay: 0.4s;"></div>
                <div class="w-2 h-2 bg-white/80 rounded-full animate-pulse" style="animation-delay: 0.6s;"></div>
                <div class="h-0.5 w-12 sm:w-16 bg-gradient-to-l from-transparent to-white/60 rounded-full"></div>
            </div>
            
            <h2 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black leading-none">
                <span class="inline-block text-yellow-300 drop-shadow-2xl">
                    Bulukumba
                </span>
            </h2>
        </div>

        <p class="text-white/95 text-base sm:text-lg lg:text-xl max-w-4xl mx-auto leading-relaxed drop-shadow-xl font-light mb-4">
            Surga bahari di ujung selatan Sulawesi Selatan
        </p>
        
        <div class="flex flex-col items-center gap-3">
            <div class="flex items-center gap-3">
                <div class="h-px w-8 sm:w-12 bg-white/40"></div>
                <p class="text-white/80 text-xs sm:text-sm font-medium tracking-wider uppercase">
                    Temukan Keindahan Yang Memukau
                </p>
                <div class="h-px w-8 sm:w-12 bg-white/40"></div>
            </div>
        </div>
    </div>
</div>

<!-- Bagian Destinasi Utama dengan Layout Grid -->
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 group relative overflow-hidden rounded-3xl shadow-2xl h-[500px] transition-all duration-700 hover:-translate-y-5 hover:shadow-3xl">
            <img src="{{ asset('images/bira.jpg') }}" alt="Pantai Tanjung Bira" class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <div class="absolute inset-0 p-8 sm:p-10 flex flex-col justify-end">
                <h3 class="text-4xl sm:text-5xl font-black text-white mb-3 drop-shadow-lg">
                    Pantai Tanjung Bira
                </h3>
                <p class="text-white/90 text-base sm:text-lg leading-relaxed max-w-2xl mb-5">
                    Pasir putih sehalus tepung bertemu air laut biru kristal. Sempurna untuk snorkeling, diving, dan menikmati sunrise yang memukau.
                </p>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-3xl shadow-2xl h-[240px] lg:h-[500px] transition-all duration-700 hover:-translate-y-5 hover:shadow-3xl">
            <img src="{{ asset('images/apparalang.jpg') }}" alt="Tebing Apparalang" class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-end">
                <h3 class="text-3xl sm:text-4xl font-black text-white mb-2 drop-shadow-lg">
                    Tebing Apparalang
                </h3>
                <p class="text-white/90 text-sm sm:text-base leading-relaxed mb-3">
                    Tebing karang dramatis dengan view Laut Flores yang spektakuler.
                </p>
            </div>
        </div>
    </div>

    <!-- Bagian Card Component -->
    <div class="mt-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-gray-800 mb-4">Destinasi Lainnya</h2>
            <div class="h-1 w-20 bg-gradient-to-r from-cyan-400 to-blue-500 mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Jelajahi lebih banyak keindahan Bulukumba yang menakjubkan</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <x-card
                image="panrangluhu.jpg" 
                title="Pantai Panrang Luhu" 
                description="Kampung nelayan otentik di tepi surga. Kehidupan pesisir yang damai dan menenangkan."
            />
           
            
            <!-- Card 2 -->
            <x-card
                image="lemo-lemo.jpg" 
                title="Pantai Lemo-lemo" 
                description="Batu karang megah bertemu air jernih kebiruan. Sanctuary untuk healing dan meditasi."
            />
            
            
            <!-- Card 3 -->
            <x-card
                image="bara.jpg" 
                title="Pantai Bara" 
                description="Sister beach dari Tanjung Bira. Suasana intimate, ideal untuk camping & quality time."
            />
           
           
            
            <!-- Card 4 -->
            <x-card
                image="titikNol.jpg" 
                title="Titik Nol" 
                description="Titik awal jalur selatan Sulawesi yang ikonik. Panorama laut infinity dengan sunset yang legendary."
            />
            
            
            <!-- Card 5 -->
            <x-card
                image="ammatoa.jpg" 
                title="Desa adat Ammatoa Kajang" 
                description="Living history dengan filosofi, Kamase-masea, Komunitas berpakaian hitam yang menolak modernitas."
            />
         
            
            
            <!-- Card 6 -->
             <x-card
                image="panrangluhu.jpg" 
                title="Pulau Liukang" 
                description="Pulau kecil dengan keindahan bawah laut yang memukau. Spot snorkeling terbaik di Bulukumba."
            />
            {{-- <div class="rounded-3xl overflow-hidden shadow-2xl bg-white hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-2 w-full">
                <img src="{{ asset('images/panrangluhu.jpg') }}" alt="Pulau Liukang" class="w-full h-56 object-cover">
                <div class="p-5">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Pulau Liukang</h3>
                    <p class="text-gray-600 text-sm leading-relaxed"></p> --}}
                </div>
            </div>
        </div>
    </div>
@endsection