@extends('layouts.master')

@section('title', 'Beranda | Eksplor Yogyakarta')

@section('content')
<!-- 🌅 Hero Section Fullscreen dengan warna coklat gelap -->
<section 
    class="relative flex items-center justify-center text-center w-full min-h-screen overflow-hidden"
    style="background-color: #1f1a17; background-image: url('/images/candi prambanan.jpeg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    <!-- Overlay semi-transparan untuk elegansi dan keterbacaan teks -->
    <div class="absolute inset-0 bg-stone-900/60"></div> 

    <!-- Teks & Tombol di atas overlay -->
    <div class="relative z-10 max-w-4xl px-6 text-white">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg 
                   opacity-0 translate-y-6 animate-fade-slide-up [animation-delay:200ms]">
            Selamat Datang di Kota Istimewa Yogyakarta
        </h1>
        <p class="text-lg md:text-xl text-stone-200/90 leading-relaxed mb-10 drop-shadow-md 
                   opacity-0 translate-y-6 animate-fade-slide-up [animation-delay:400ms]">
            Jelajahi pesona budaya, sejarah, dan keramahan yang membuat Yogyakarta begitu istimewa — dari Malioboro hingga Candi Prambanan.
        </p>
        <a href="/destinasi" 
           class="inline-block bg-stone-100 hover:bg-white text-stone-900 font-bold py-3 px-8 rounded-full shadow-2xl transition transform hover:scale-105 duration-300
                  opacity-0 translate-y-6 animate-fade-slide-up [animation-delay:600ms] tracking-wider">
           Jelajahi Sekarang →
        </a>
    </div>
</section>

<!-- ✨ Konten Utama / Fitur Unggulan dengan latar coklat gelap elegan -->
<section class="px-6 py-12" style="background-color: #1f1a17;">
    <div class="container mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold text-stone-100 mb-6">
            Mengapa Yogyakarta?
        </h2>
        <p class="max-w-2xl mx-auto text-stone-300">
            Yogyakarta bukan sekadar kota, melainkan pengalaman — perpaduan harmonis antara sejarah, seni, alam, dan kehidupan masyarakat yang penuh kehangatan.
        </p>
        
        <!-- Cards / Fitur dengan desain elegan -->
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="bg-stone-900/80 p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border border-stone-700 text-stone-100">
                <h3 class="font-bold text-xl mb-3">1. Kota Budaya</h3>
                <p>Tempat di mana tradisi, tarian klasik, gamelan, dan upacara adat tetap hidup di tengah modernitas.</p>
            </div>
            <div class="bg-stone-900/80 p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border border-stone-700 text-stone-100">
                <h3 class="font-bold text-xl mb-3">2. Keindahan Alam</h3>
                <p>Dari perbukitan Menoreh hingga pantai selatan, setiap sudut Yogyakarta memanjakan mata dan jiwa.</p>
            </div>
            <div class="bg-stone-900/80 p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 border border-stone-700 text-stone-100">
                <h3 class="font-bold text-xl mb-3">3. Kuliner & Keramahan</h3>
                <p>Nikmati Gudeg, Kopi Joss, dan senyum hangat warga lokal yang selalu menyambut dengan ramah.</p>
            </div>
        </div>
    </div>
</section>

<!-- ✨ Animasi Custom untuk Hero Section -->
<style>
@keyframes fade-slide-up {
  0% { opacity: 0; transform: translateY(24px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-slide-up {
  animation: fade-slide-up 1s ease-out forwards;
}
html, body {
    margin: 0;
    padding: 0;
    background-color: #1f1a17;
}
</style>
@endsection
