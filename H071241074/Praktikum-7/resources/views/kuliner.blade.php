@extends('layouts.master')

@section('title', 'Kuliner')

@section('content')
    <div class="relative min-h-screen flex flex-col items-center -mt-28 overflow-x-hidden">
        
        <div class="absolute inset-0 bg-cover bg-center bg-fixed -z-10" style="background-image: url('{{ asset('images/lantai.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/meja.png') }}');">
        </div>
        
        <h1 class="text-6xl relative left-[490px] text-gray-800 mb-12 tracking-wide mt-32 z-20">
            Kuliner di Soppeng
        </h1>
        
        <div class="w-full max-w-7xl px-4 flex justify-center space-x-8">
            <div class="w-1/3 rounded-3xl overflow-hidden p-4 text-center transform hover:scale-[1.02] transition duration-300">
                <div class="rounded-full w-64 h-64 mx-auto overflow-hidden relative -mt-2"> 
                    <img src="{{ asset('images/bale.png') }}" alt="Gambar Bale Macca" class="w-full h-full object-cover">
                </div>

                <h2 class="text-3xl text-white -mt-7 tracking-wide ">
                    Bale Macca
                </h2>

                <p class="text-white text-sm tracking-wider ">
                    Masakan ikan bakar atau goreng khas Soppeng yang dibumbui rempah Bugis, biasanya disajikan dengan sambal rica dan nasi hangat.
                </p>
            </div>

            <div class="w-1/3 rounded-3xl overflow-hidden p-4 text-center transform hover:scale-[1.02] transition duration-300">
                <div class="rounded-full w-64 h-64 mx-auto overflow-hidden relative -mt-2"> 
                    <img src="{{ asset('images/likku.png') }}" alt="Gambar Nasu Likku" class="w-full h-full object-cover">
                </div>

                <h2 class="text-3xl text-white -mt-7 tracking-wider ">
                    Nasu Likku
                </h2>

                <p class="text-white text-sm tracking-wider">
                    Olahan daging ayam dengan bumbu lengkuas, santan, dan rempah khas Bugis. Rasanya gurih dan sedikit pedas.
                </p>
            </div>

            <div class="w-1/3 rounded-3xl overflow-hidden p-4 text-center transform hover:scale-[1.02] transition duration-300">
                
                <div class="rounded-full w-64 h-64 mx-auto overflow-hidden relative -mt-2"> 
                    <img src="{{ asset('images/bolu.png') }}" alt="Gambar Bolu Cukke" class="w-full h-full object-cover">
                </div>

                <h2 class="text-3xl text-white -mt-7 tracking-wider ">
                    Bolu Cukke
                </h2>

                <p class="text-white text-sm tracking-wider ">
                    Kue tradisional khas Soppeng berbahan dasar tepung terigu dan gula merah, memiliki rasa manis legib dengan tekstur lembut.
                </p>
            </div>
        </div>
    </div>
@endsection