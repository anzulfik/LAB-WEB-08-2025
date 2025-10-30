@extends('layouts.master')

@section('title', 'Galeri | Eksplor Yogyakarta')

@section('content')
<section class="py-16 px-6 bg-stone-50">
    <div class="max-w-7xl mx-auto text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-extrabold text-stone-900 drop-shadow-md tracking-wide">
            🏙️ Galeri Keindahan Yogyakarta
        </h2>
        <p class="text-stone-700 mt-4 text-lg md:text-xl">
            Jelajahi keindahan Yogyakarta melalui koleksi foto terbaik kami.
        </p>
    </div>

    <div class="columns-1 sm:columns-2 lg:columns-4 gap-6 space-y-6">
       
        @foreach($gallery as $item)
        <div class="relative break-inside mb-6 group rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-500 transform hover:-translate-y-1">
            <img src="{{ asset($item['img']) }}" 
                 alt="{{ $item['title'] }}" 
                 class="w-full h-64 object-cover rounded-3xl transition-transform duration-500 group-hover:scale-105">

            <!-- Overlay tag muncul saat hover -->
            <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition duration-500 flex items-start justify-start p-4">
                <span class="bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-md">
                    {{ $item['tag'] }}
                </span>
            </div>

            <!-- Judul di bawah gambar dengan gradient -->
            <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-4">
                <h3 class="text-white font-bold text-lg md:text-xl drop-shadow-lg">{{ $item['title'] }}</h3>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
