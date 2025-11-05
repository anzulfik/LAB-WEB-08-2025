@extends('layouts.master')

@section('title', 'Peta')

@section('content')
    <div class="relative min-h-screen -mt-28 flex items-center justify-center overflow-hidden">
        
        <div class="absolute inset-0 bg-cover bg-center -z-10" style="background-image: url('{{ asset('images/peta.png') }}');">
        </div>

        <div class="relative z-10 w-full h-full max-w-7xl mx-auto flex items-center justify-between px-10 py-20"> 
            <div class="w-1/3 text-gray-800 tracking-wider">
                <h1 class="text-6xl leading-tight">
                    Peta Destinasi<br>& Kuliner di<br>Soppeng
                </h1>
                
                <img src="{{ asset('images/hiasan-petacoi.png') }}" alt="Peta Pin" class="w-20 h-20 -mt-20 absolute left-[270px]"> 
            </div>
            
            <div class="relative w-2/3 h-full">
                <a href="https://maps.app.goo.gl/gCxSL9UUyKNyyev96?g_st=ipc" target="_blank" 
                    class="group absolute w-12 h-12 top-10 right-0 hover:scale-125 transition duration-300">
                    <span class="text-sm opacity-0 group-hover:opacity-100"> Mattabulu </span>
                    <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 1" class="w-full h-full">
                </a>
                
                <a href="https://maps.app.goo.gl/gCxSL9UUyKNyyev96?g_st=ipc" target="_blank"
                   class="group absolute w-12 h-12 top-40 right-20 hover:scale-125 transition duration-300">
                   <span class="text-sm opacity-0 group-hover:opacity-100 whitespace-nowrap"> Liu Pangi'e </span>
                   <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 2" class="w-full h-full">
                </a>
                
                <a href="https://maps.app.goo.gl/jTSoWbhkGbNVHaVj9?g_st=ipc" target="_blank" 
                   class="group absolute w-12 h-12 top-20 left-40 hover:scale-125 transition duration-300">
                   <span class="text-sm opacity-0 group-hover:opacity-100"> Lejja </span>
                   <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 3" class="w-full h-full">
                </a>

                <a href="https://share.google/bAe84EpVEHYmnSBT1" target="_blank" 
                   class="group absolute w-12 h-12 bottom-20 left-32 hover:scale-125 transition duration-300">
                   <span class="text-sm opacity-0 group-hover:opacity-100 whitespace-nowrap"> Rumah Makan Baselo </span>
                   <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 4" class="w-full h-full">
                </a>

                <a href="https://maps.app.goo.gl/R5VMBypkqaJBGjaV9?g_st=ipc" target="_blank" 
                   class="group absolute w-12 h-12 top-5 left-1/2 -translate-x-1/2 hover:scale-125 transition duration-300">
                   <span class="text-sm opacity-0 group-hover:opacity-100 whitespace-nowrap"> Bebek Timusu </span>
                   <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 5" class="w-full h-full">
                </a>

                <a href=" https://maps.app.goo.gl/uyQhM8gooT7eALb4A?g_st=ipc" target="_blank" 
                   class="group absolute w-12 h-12 bottom-10 left-1/2 -translate-x-1/2 hover:scale-125 transition duration-300">
                   <span class="text-sm opacity-0 group-hover:opacity-100 whitespace-nowrap"> Bolu Cukke SunriseQ </span>
                   <img src="{{ asset('images/map-pin.png') }}" alt="Destinasi 6" class="w-full h-full">
                </a>
            </div>
        </div> 
    </div>
@endsection