@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

<section id="welcome" class="relative text-left min-h-screen w-full bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Home.png') }}');">
    <div class="absolute z-10 mt-44 ml-12">
        <h1 class="font-semibold text-8xl mt-5 mb-4 text-blue-700 leading-none">
            Sistem Manajemen <br> Produk!
        </h1>

        <a href="{{ route('categories.index') }}"
            class="gradient-btn text-lg text-white font-semibold px-5 py-3 inline-block transition">
            Tambahkan Kategori Produk
        </a>
    </div>
</section>

@endsection
