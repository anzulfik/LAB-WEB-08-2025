@extends('layouts.master')

@section('title', 'Kuliner Khas Yogyakarta')

@section('content')
<section class="py-12 px-6 bg-gradient-to-b from-stone-50 via-stone-100 to-stone-50">
    <div class="max-w-7xl mx-auto text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-extrabold text-stone-900 drop-shadow-md">
            🍽️ Kuliner Khas Yogyakarta
        </h2>
        <p class="text-stone-700 mt-4 text-lg md:text-xl">
            Rasakan kelezatan kuliner khas Yogyakarta, dari yang legendaris hingga yang unik dan pedas menggoda.
        </p>
    </div>

    <div class="space-y-16">
       
        @foreach($foods as $index => $food)
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-12 
                    @if($index % 2 != 0) md:flex-row-reverse @endif opacity-0 translate-y-6 animate-fade-slide-up">
            <img src="{{ asset($food['image']) }}" 
                 alt="{{ $food['title'] }}"
                 class="w-full md:w-1/2 rounded-2xl shadow-2xl hover:scale-105 transition-transform duration-500">

            <div class="md:w-1/2 space-y-4 text-center md:text-left">
                <h3 class="text-2xl md:text-3xl font-bold text-stone-900 drop-shadow-sm">
                    {{ $food['title'] }}
                </h3>
                <p class="text-stone-700 leading-relaxed text-lg">
                    {{ $food['desc'] }}
                </p>
                <span class="inline-block bg-amber-400 text-stone-900 px-3 py-1 rounded-full font-semibold text-sm drop-shadow-md">
                    @if(str_contains($food['title'],'Gudeg') || str_contains($food['title'],'Bakpia')) Manis 
                    @elseif(str_contains($food['title'],'Sate') || str_contains($food['title'],'Oseng')) Pedas 
                    @else Hangat @endif
                </span>
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
