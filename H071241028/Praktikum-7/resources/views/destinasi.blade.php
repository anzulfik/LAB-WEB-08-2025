@extends('layouts.master')

@section('title', 'Destinasi | Eksplor Yogyakarta')

@section('content')
<section class="py-12 px-6 bg-gradient-to-b from-stone-50 via-stone-100 to-stone-50">
    <div class="max-w-7xl mx-auto text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-extrabold text-stone-900 drop-shadow-sm tracking-wide">
            Destinasi Unggulan di Yogyakarta
        </h2>
        <p class="text-stone-700 mt-4 text-lg md:text-xl">
            Jelajahi berbagai tempat ikonik dan tersembunyi di Yogyakarta yang memikat hati wisatawan.
        </p>
    </div>
    
    {{-- Grid Card --}}
    <div class="grid md:grid-cols-3 gap-8 lg:gap-10">
        
        <x-card 
            title="Candi Prambanan" 
            image="/images/candi prambanan 1.jpeg" 
            description="Candi Prambanan berdiri megah sebagai mahakarya arsitektur Hindu terbesar di Indonesia, memancarkan keindahan dan kisah cinta abadi Ramayana di setiap reliefnya."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Ikonik
            </span>
        </x-card>

        <x-card 
            title="Taman Sari" 
            image="/images/Taman sari.jpeg" 
            description="Taman Sari Yogyakarta memikat dengan pesona kolam biru, lorong bawah tanah, dan bangunan kuno yang menyimpan jejak romantisme para sultan di masa lalu."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Romantis
            </span>
        </x-card>

        <x-card 
            title="Jalan Malioboro" 
            image="/images/Jalan Malioboro.jpeg" 
            description="Jalan Malioboro adalah jantung kehidupan Yogyakarta, tempat lampu kota, aroma kuliner, dan alunan musik jalanan berpadu menciptakan suasana malam yang hangat dan tak terlupakan."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Ikonik
            </span>
        </x-card>

        <x-card 
            title="Keraton Yogyakarta" 
            image="/images/Keraton Jogyakarta.jpeg" 
            description="Keraton Yogyakarta adalah pusat budaya dan sejarah Jawa, tempat di mana tradisi, keanggunan, dan filosofi hidup kerajaan masih terjaga dengan khidmat hingga kini."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Sejarah
            </span>
        </x-card>

        <x-card 
            title="Candi Borobudur" 
            image="/images/candi borobudur.jpeg" 
            description="Candi Borobudur menjulang anggun di tengah kabut pagi, menghadirkan harmoni antara kemegahan arsitektur dan kedamaian spiritual yang menenangkan jiwa."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Spiritual
            </span>
        </x-card>

        <x-card 
            title="Pantai Jungwok" 
            image="/images/Pantai Jungwok.jpeg" 
            description="Pantai Jungwok memanjakan mata dengan pasir putih lembut, tebing hijau menjulang, dan deburan ombak Samudra Hindia yang menghadirkan ketenangan alami nan eksotis."
            class="transition transform hover:scale-105 hover:shadow-2xl duration-500 relative overflow-hidden group">
            <span class="absolute top-4 left-4 bg-amber-400 text-stone-900 font-bold px-3 py-1 rounded-full text-sm drop-shadow-lg opacity-0 group-hover:opacity-100 transition duration-300">
                Eksotis
            </span>
        </x-card>
    </div>
</section>
@endsection
