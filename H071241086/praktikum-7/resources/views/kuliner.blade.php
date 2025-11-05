@extends('layouts.master')
@section('title', 'Kuliner - Eksplor Bulukumba')

@section('content')
<div class="bg-gradient-to-b from-orange-50 via-white to-yellow-50 min-h-screen py-16">
    <!-- Header Section -->
    <div class="relative -mt-8 -mx-4 sm:-mx-6 lg:-mx-8 mb-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 via-red-500 to-amber-600">
            <div class="absolute top-0 left-0 w-96 h-96 bg-red-500/30 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute top-20 right-0 w-[500px] h-[500px] bg-orange-400/40 rounded-full blur-3xl animate-pulse" style="animation-delay: 1.5s; animation-duration: 4s;"></div>
            <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-amber-400/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 3s; animation-duration: 5s;"></div>
        </div>

        <div class="relative z-10 text-center py-12 sm:py-16 px-4">
            <div class="mb-6">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-white mb-3 leading-none tracking-tight" style="text-shadow: 6px 6px 12px rgba(0,0,0,0.4);">
                    Kuliner Khas
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
                Nikmati cita rasa khas Bulukumba — dari olahan laut segar hingga kue tradisional yang penuh makna budaya dan kehangatan.
            </p>
        </div>
    </div>

    <!-- Kuliner Cards Section -->
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          
                
            @foreach ($menus as $menu)
            <div class="rounded-3xl overflow-hidden shadow-2xl bg-white hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-2 w-full max-w-sm mx-auto {{ $menu['color'] }}">
                @if ($menu['badge'])
                <div class="absolute top-4 right-4 z-10">
                    <div class="bg-gradient-to-br from-orange-500 to-red-500 text-white px-3 py-1 rounded-full font-bold text-xs shadow-lg border-2 border-white">
                        {{ $menu['badge'] }}
                    </div>
                </div>
                @endif
                <div class="relative">
                    <img src="{{ asset('images/' . $menu['img']) }}" alt="{{ $menu['title'] }}" class="w-full h-56 object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent h-16"></div>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $menu['title'] }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $menu['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer Message -->
    <div class="mt-16 text-center max-w-4xl mx-auto px-4">
        <div class="bg-white/80 backdrop-blur-md rounded-3xl p-8 border border-orange-200 shadow-lg">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Warisan Rasa Nusantara</h3>
            <p class="text-gray-700 text-lg leading-relaxed">
                Setiap hidangan menceritakan warisan budaya dan cita rasa Bulukumba yang telah diturunkan dari generasi ke generasi, 
                mencerminkan kekayaan alam dan kearifan lokal masyarakat Sulawesi Selatan.
            </p>
        </div>
    </div>
</div>
@endsection