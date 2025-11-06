@extends('layouts.master')

@section('page-id', 'destination-page')
@section('main-class', 'destination-container')
@section('title', 'Destinasi Wisata')

@section('content')

    <section class="dest-image-grid-section">
        <div class="dest-grid-item">
            <img src="{{ asset('images/barelang-bridge.jpg') }}" alt="Jembatan Barelang">
            <h2>Jembatan Barelang</h2>
        </div>
        <div class="dest-grid-item">
            <img src="{{ asset('images/ocarina2.webp') }}" alt="Ocarina Batam Theme Park">
            <h2>Ocarina Theme Park</h2>
        </div>
        <div class="dest-grid-item">
            <img src="{{ asset('images/telaga-bidadari2.jpg') }}" alt="Telaga Bidadari">
            <h2>Telaga Bidadari</h2>
        </div>
    </section>
    <section class="dest-caption-section">
        <div class="dest-caption-grid">
            <div class="dest-caption-item">
                <h3>Pantai Tanjung Layar</h3>
                <p>jembatan Barelang adalah sebuah rangkaian enam jembatan yang menghubungkan 
                Pulau Batam dengan beberapa pulau lain di Kepulauan Riau, seperti Tonton, 
                Nipah, Setotok, Rempang, Galang, dan Galang Baru. Nama "Barelang" 
                merupakan singkatan dari Batam, Rempang, dan Galang.</p>
            </div>
            <div class="dest-caption-item">
                <h3>Ocarina Theme Park</h3>
                <p>Ocarina Batam Theme Parksebuah taman hiburan dan objek wisata terpadu di Batam yang menggabungkan 
                wisata alam, wahana permainan, dan kuliner. Tempat ini memiliki pantai 
                berpasir putih buatan, waterpark, dan beragam wahana seperti kincir 
                angin raksasa dan 360 Madness.</p>
            </div>
            <div class="dest-caption-item">
                <h3>Telaga Bidadari</h3>
                <p>Telaga Bidadari Batam adalah objek wisata alam "surga tersembunyi" di 
                    tengah hutan Simpang Dam, Muka Kuning, Batam, yang menawarkan air terjun, 
                    kolam alami jernih, dan suasana asri.</p>
            </div>
        </div>
    </section>

    <section class="dest-map-section">
        <div id="dest-map-container"></div>
    </section>

@endsection

@push('scripts')
<script>
    const locations = [
        {
            name: "Jembatan Barelang",
            desc: "Ikon utama Batam.",
            coords: [0.9817018774769447, 104.041369771098539]
        },
        {
            name: "Ocarina Batam Theme Park",
            desc: "Theme Park terbesar di Batam.",
            coords: [1.1531308410004009, 104.05680098234531]
        },
        {
            name: "Telaga Bidadari",
            desc: "Pantai dengan hamparan pasir putih.",
            coords: [1.0729271528336606, 103.99909159431107]
        }
    ];

    var map = L.map('dest-map-container');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var bounds = [];

    locations.forEach(loc => {
        L.marker(loc.coords).addTo(map)
            .bindPopup(`<b>${loc.name}</b><br>${loc.desc}`);

        bounds.push(loc.coords);
    });

    map.fitBounds(bounds, { padding: [50, 50] });
</script>
@endpush