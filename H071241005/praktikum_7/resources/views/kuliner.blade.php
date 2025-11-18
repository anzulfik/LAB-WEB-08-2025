@extends('layouts.master')

@section('title', 'Kuliner - Eksplor Tana Toraja')

@section('content')
    <div class="relative h-96 bg-gray-800">
        <img src="{{ asset('images/kuliner_hero.jpg') }}" alt="Kuliner Tana Toraja" class="w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Kuliner Khas</h1>
                <p class="text-lg md:text-xl max-w-2xl">Cicipi cita rasa otentik dari masakan tradisional Toraja yang kaya bumbu.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        
        <div class="grid md:grid-cols-3 gap-8">

            <x-card
                imgSrc="papiong.jpg"
                tag="Masakan Utama"
                title="Pa'piong"
                description="Masakan khas Toraja yang dimasak di dalam batang bambu. Berisi daging (ayam, babi, atau ikan) yang dicampur dengan bumbu rempah dan daun miana."
            />

            <x-card
                imgSrc="pamarrasan.jpg"
                tag="Bumbu Khas"
                title="Pantollo' Pamarrasan"
                description="Daging yang dimasak dengan bumbu kluwak hitam khas Toraja (pamarrasan). Memberikan rasa gurih yang unik dan warna hitam pekat yang khas."
            />

            <x-card
                imgSrc="tuak.jpeg"
                tag="Minuman"
                title="Tuak (Ballo')"
                description="Minuman fermentasi tradisional dari nira pohon aren. Memiliki peran penting dalam setiap upacara adat dan kehidupan sosial masyarakat Toraja."
            />

        </div>
    </div>
@endsection