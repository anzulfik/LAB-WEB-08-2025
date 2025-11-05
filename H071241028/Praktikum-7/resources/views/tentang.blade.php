@extends('layouts.master')

@section('title', 'Tentang Kami')

@section('content')
<section class="relative w-full py-20 px-6 bg-stone-900 text-stone-100">
    
    <!-- Background dekoratif -->
    <div class="absolute inset-0 bg-stone-900/80 -z-10"></div>
    
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
        
        <!-- Kiri: Gambar -->
        <div class="flex-1">
            <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                <img src="{{ asset('images/Jogja.jpeg') }}" 
                     alt="Tugu Yogyakarta"
                     class="w-full h-auto object-cover rounded-3xl transition-transform duration-500 hover:scale-105">
            </div>
        </div>
        
        <!-- Kanan: Teks -->
        <div class="flex-1 space-y-6">
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-wide drop-shadow-lg opacity-0 translate-y-6 animate-fade-slide-up">
                Tentang Eksplor Yogyakarta 
            </h2>
            
            <p class="text-lg md:text-xl leading-relaxed text-stone-200 opacity-0 translate-y-6 animate-fade-slide-up [animation-delay:200ms]">
                Eksplor Yogyakarta hadir sebagai panduan digital untuk mengenal lebih dekat keistimewaan kota budaya ini. 
                Kami menampilkan keindahan alam, kekayaan sejarah, serta tradisi yang hidup di setiap sudut Yogyakarta — 
                dari Candi Prambanan hingga Malioboro.
            </p>
            
            <p class="text-lg md:text-xl leading-relaxed text-stone-200 opacity-0 translate-y-6 animate-fade-slide-up [animation-delay:400ms]">
                Kami percaya Yogyakarta bukan sekadar destinasi, melainkan ruang hidup yang memadukan seni, budaya, 
                dan keramahan warganya. Melalui Eksplor Yogyakarta, Anda diajak menikmati pengalaman autentik dan bermakna, 
                serta mendukung pelestarian budaya dan pariwisata berkelanjutan.
            </p>
        </div>
    </div>
</section>

<style>
@keyframes fade-slide-up {
  0% { opacity: 0; transform: translateY(24px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-slide-up {
  animation: fade-slide-up 1s ease-out forwards;
}
</style>
@endsection
