@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <div class="relative min-h-screen -mt-28 flex items-center justify-center overflow-x-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/watansoppeng.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/kalelawar.png') }}');">
        </div>

        <div class="relative z-10 text-white tracking-wider w-full">
            <p class="text-3xl -mt-[230px] absolute left-32 tracking-wider"">Selamat Datang di</p>
            <p class="text-lg -mt-[70px] absolute left-36 max-w-xl">
                Temukan pesona Kabupaten Soppeng, daerah berhawa sejuk di jantung Sulawesi Selatan yang dikenal dengan ribuan kelelawar (kalong) yang menghiasi langit Watansoppeng setiap senja.
            </p>
            <a href="/destinasi" class="absolute mt-6 left-36 inline-block px-6 py-2 text-lg text-black bg-white/60 rounded-full hover:bg-white transition duration-300 hover:shadow-2xl">
                Jelajahi
            </a>
        </div> 
    </div>
@endsection