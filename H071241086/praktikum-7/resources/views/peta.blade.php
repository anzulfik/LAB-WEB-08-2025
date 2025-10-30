@extends('layouts.master')
@section('title', 'Peta Wisata - Eksplor Bulukumba')

@section('content')
<section class="bg-gradient-to-br from-teal-900 via-cyan-900 to-sky-900 min-h-screen py-16 px-6">
  <div class="max-w-6xl mx-auto">
    <header class="text-center mb-10">
      <h1 class="text-3xl md:text-4xl font-extrabold text-white drop-shadow-lg tracking-tight">
        🗺️ Peta Wisata Bulukumba
      </h1>
      <p class="mt-3 text-sm md:text-base text-teal-100/90 max-w-2xl mx-auto leading-relaxed">
        Temukan lokasi destinasi populer di Kabupaten Bulukumba — termasuk
        <span class="font-semibold text-cyan-200">Pantai Tanjung Bira</span>,
        <span class="font-semibold text-cyan-200">Apparalang</span>,
        <span class="font-semibold text-cyan-200">Ammatoa Kajang</span>, dan
        <span class="font-semibold text-cyan-200">Pantai Bara</span>.
      </p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
      <div class="lg:col-span-2">
        <div class="bg-white/10 border border-white/10 rounded-2xl overflow-hidden shadow-2xl">
          <div class="px-5 py-3 bg-white/5 backdrop-blur-md border-b border-white/10">
            <h2 class="text-white text-lg font-bold">Peta Lokasi Wisata</h2>
            <p class="text-sm text-teal-100/70">Perbesar atau aktifkan mode satelit untuk detail pantai dan jalur wisata.</p>
          </div>

          <div class="relative w-full h-[550px]">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63759.23940487565!2d120.0627653!3d-5.5667158!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbe2f92cba3f1cb%3A0x8f42b4c663e2445!2sBulukumba%2C%20Sulawesi%20Selatan!5e0!3m2!1sid!2sid!4v1729911111111!5m2!1sid!2sid"
              class="absolute top-0 left-0 w-full h-full border-0 rounded-b-2xl"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>

        <div class="mt-4 flex flex-wrap gap-3">
          <span class="inline-flex items-center gap-2 bg-white/10 text-teal-100 px-4 py-2 rounded-lg text-sm border border-white/10 shadow-sm">
            🌐 Gunakan mode satelit untuk melihat detail pantai dan garis laut
          </span>
        </div>
      </div>
      <div class="bg-white/5 border border-white/10 rounded-xl p-5 text-sm text-teal-100/90 backdrop-blur-md">
        <div class="font-semibold text-white mb-2">Destinasi Populer</div>
        @php
          $destinasi = [
              ['title'=>'Pantai Tanjung Bira','link'=>'https://www.google.com/maps/place/Pantai+Tanjung+Bira/@-5.5981,120.1121,17z'],
              ['title'=>'Tebing Apparalang','link'=>'https://www.google.com/maps/place/Tebing+Apparalang/@-5.6075,120.0735,17z'],
              ['title'=>'Desa Ammatoa Kajang','link'=>'https://www.google.com/maps/place/Desa+Ammatoa+Kajang/@-5.5998,120.0512,17z'],
              ['title'=>'Pantai Panrang Luhu','link'=>'https://www.google.com/maps/place/Pantai+Panrang+Luhu/@-5.5830,120.0987,17z'],
              ['title'=>'Pantai Lemo-Lemo','link'=>'https://www.google.com/maps/place/Pantai+Lemo-Lemo/@-5.5684,120.1023,17z'],
              ['title'=>'Pantai Bara','link'=>'https://www.google.com/maps/place/Pantai+Bara/@-5.5701,120.1105,17z'],
              ['title'=>'Titik Nol','link'=>'https://www.google.com/maps/place/Titik+Nol/@-5.5625,120.0731,17z'],
          ];
        @endphp
        <ul class="space-y-2">
          @foreach ($destinasi as $item)
            <li>
              <a href="{{ $item['link'] }}" target="_blank" class="text-cyan-200 font-semibold hover:underline">
                • {{ $item['title'] }}
              </a>
            </li>
          @endforeach
        </ul>

        <div class="mt-4 font-semibold text-white mb-2">Tips Wisata</div>
        <ul class="space-y-1.5">
          <li>• Gunakan fitur pencarian di peta untuk menemukan lokasi wisata.</li>
          <li>• Aktifkan <span class="text-cyan-200 font-semibold">mode satelit</span> untuk tampilan garis pantai yang lebih detail.</li>
          <li>• Pastikan memeriksa <span class="text-yellow-300 font-semibold">jam buka</span> dan informasi terbaru sebelum berkunjung.</li>
        </ul>
      </div>

    </div>
  </div>
</section>
@endsection