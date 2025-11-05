@extends('layouts.master')

@section('page-id', 'contact')
@section('title', 'Kontak')

@section('content')
    <h2>Hubungi Kami</h2>
    <p>Punya pertanyaan atau ingin merencanakan perjalanan? Hubungi kami!</p>
    
    <p>
        <strong>Email:</strong> info@batam.com<br>
        <strong>Telepon:</strong> +62 123 4567 890
    </p>

    <div id="map-container"></div>

    <hr style="margin: 30px 0; border-color: rgba(255,255,255,0.3);">

    <form action="#" method="POST">
        <div class="form-group">
            <label for="nama">Nama Anda:</label>
            <input type="text" id="nama" name="nama">
        </div>
        <div class="form-group">
            <label for="email">Email Anda:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="pesan">Pesan:</label>
            <textarea id="pesan" name="pesan" rows="5"></textarea>
        </div>
        <button type="submit">Kirim Pesan</button>
    </form>
@endsection

@push('scripts')
<script>
    var lat = 1.128177007240684;
    var lon = 104.05566449431096;
    var map = L.map('map-container').setView([lat, lon], 14); 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    L.marker([lat, lon]).addTo(map)
        .bindPopup('<b>Batam, indonesia</b>')
        .openPopup();
</script>
@endpush