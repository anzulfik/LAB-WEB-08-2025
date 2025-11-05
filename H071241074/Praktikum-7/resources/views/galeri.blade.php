@extends('layouts.master')

@section('title', 'Galeri')

@section('content')
    <div class="relative min-h-screen -mt-28 flex flex-col items-center overflow-x-hidden">
        <div class="absolute inset-0 bg-cover bg-center -z-10 opacity-70" style="background-image: url('{{ asset('images/galeri.png') }}');">
        </div>

        <div class=" text-white tracking-wider mt-36 ">
            <h1 class="text-5xl mb-12 tracking-wide pb-2">
                Galeri Foto Soppeng
            </h1>
            
            <img src="{{ asset('images/hiasan-galeri1.png') }}" alt="Hiasan Galeri" class="w-12 h-12 -mt-20 absolute right-[510px]"> 
            <img src="{{ asset('images/hiasan-galeri2.png') }}" alt="Hiasan Galeri" class="w-20 h-20 -mt-28 absolute left-[475px]"> 
        </div>
        
        <div class="w-full max-w-7xl px-4 grid grid-cols-3 gap-6">
            <div class="col-span-2 relative overflow-hidden rounded-xl shadow-2xl group cursor-pointer">
                <img src="{{ asset('images/villa.png') }}" alt="Villa Yuliana" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-6">
                    <p class="text-white text-lg tracking-wider">Villa Yuliana</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl shadow-lg group cursor-pointer">
                <img src="{{ asset('images/tamkal.png') }}" alt="Taman Kalong" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <p class="text-white text-base tracking-wider">Taman Kalong</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl shadow-lg group cursor-pointer">
                <img src="{{ asset('images/sao-mario.png') }}" alt="Sao Mario" class="w-full h-72 object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <p class="text-white text-base tracking-wider">Rumah Adat Sao Mario</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl shadow-lg group cursor-pointer">
                <img src="{{ asset('images/kalong.png') }}" alt="Kalong" class="w-full h-72 object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <p class="text-white text-base tracking-wider">Kalong di Soppeng</p>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl shadow-lg group cursor-pointer">
                <img src="{{ asset('images/galeri-lejja.png') }}" alt="Lejja" class="w-full h-72 object-cover transition duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <p class="text-white text-base tracking-wider">Permandian Air Panas Lejja</p>
                </div>
            </div>
        </div>
    </div>
@endsection