@extends('layouts.master')

@section('title', 'Event | Eksplor Yogyakarta')

@section('content')
<section class="py-16 px-6 bg-gradient-to-b from-stone-50 via-stone-100 to-stone-50">
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-extrabold text-stone-900 drop-shadow-md tracking-wide">
            📅 Event dan Festival Yogyakarta
        </h2>
        <p class="text-stone-700 mt-4 text-lg md:text-xl">
            Ikuti beragam festival dan perayaan budaya yang membuat Yogyakarta semakin hidup dan berwarna.
        </p>
    </div>

    <div class="space-y-16">
        
        @foreach($events as $index => $event)
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12 
                    @if($index % 2 != 0) md:flex-row-reverse @endif opacity-0 translate-y-6 animate-fade-slide-up">
            
            <!-- Gambar dengan overlay ringan -->
            <div class="relative w-full md:w-1/2 overflow-hidden rounded-2xl shadow-2xl group">
                <img src="{{ asset($event['image']) }}" alt="{{ $event['title'] }}" 
                     class="w-full h-72 md:h-96 object-cover transform transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-40 transition duration-500"></div>
            </div>

            <!-- Konten teks -->
            <div class="md:w-1/2 space-y-4 text-center md:text-left">
                <h3 class="text-3xl md:text-4xl font-bold text-stone-900 drop-shadow-sm">
                    {{ $event['title'] }}
                </h3>
                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                    @foreach($event['tags'] as $tag)
                    <span class="bg-amber-400 text-stone-900 px-3 py-1 rounded-full font-semibold text-sm drop-shadow-md">
                        #{{ $tag }}
                    </span>
                    @endforeach
                </div>
                <p class="text-stone-700 leading-relaxed text-lg">
                    {{ $event['desc'] }}
                </p>
                <a href="#" class="inline-block mt-4 bg-stone-900 text-stone-50 font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-stone-800 transition transform hover:scale-105">
                    Lihat Detail →
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

<style>
@keyframes fade-slide-up {
  0% { opacity: 0; transform: translateY(24px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-slide-up {
  animation: fade-slide-up 1s ease-out forwards;
}
</style>
@endsection
