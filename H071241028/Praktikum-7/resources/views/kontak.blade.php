@extends('layouts.master')

@section('title', 'Kontak Kami')

@section('content')
<section class="container mx-auto px-6 py-16">
    {{-- 1. PERBAIKAN: Ganti text-amber-500 menjadi Coklat Tua (stone-900) --}}
    <h2 class="text-4xl font-extrabold text-center text-stone-900 mb-12 drop-shadow-sm tracking-wider">
        Hubungi Kami 
    </h2>

    {{-- 2. PERBAIKAN: Background Formulir menjadi Terang --}}
    <div class="max-w-xl mx-auto bg-stone-50 p-8 md:p-10 rounded-2xl shadow-2xl border-t-4 border-stone-900">
        <form class="space-y-6">
            
            <div>
                {{-- Text Label Coklat Tua --}}
                <label for="nama" class="block mb-2 font-semibold text-stone-800">Nama Lengkap:</label>
                {{-- Input: Background Putih, Teks Coklat Tua, Focus Coklat Tua --}}
                <input 
                    type="text" 
                    id="nama" 
                    class="w-full border border-stone-300 bg-white text-stone-900 p-3 rounded-xl focus:border-stone-900 focus:ring-2 focus:ring-stone-900/50 transition duration-200 placeholder:text-stone-500" 
                    placeholder="Contoh: Budi Santoso" 
                    required>
            </div>

            <div>
                <label for="email" class="block mb-2 font-semibold text-stone-800">Alamat Email:</label>
                <input 
                    type="email" 
                    id="email" 
                    class="w-full border border-stone-300 bg-white text-stone-900 p-3 rounded-xl focus:border-stone-900 focus:ring-2 focus:ring-stone-900/50 transition duration-200 placeholder:text-stone-500" 
                    placeholder="email@contoh.com" 
                    required>
            </div>

            <div>
                <label for="pesan" class="block mb-2 font-semibold text-stone-800">Pesan Anda:</label>
                <textarea 
                    id="pesan" 
                    class="w-full border border-stone-300 bg-white text-stone-900 p-3 rounded-xl focus:border-stone-900 focus:ring-2 focus:ring-stone-900/50 transition duration-200 placeholder:text-stone-500" 
                    rows="5" 
                    placeholder="Tuliskan pesan Anda di sini..." 
                    required></textarea>
            </div>

            {{-- 4. PERBAIKAN: Tombol menjadi Coklat Tua (stone-900) --}}
            <button class="w-full bg-stone-900 text-stone-100 font-bold text-lg px-4 py-3 rounded-xl hover:bg-stone-800 transition transform hover:scale-[1.01] duration-300 shadow-xl shadow-stone-900/50 tracking-wider" type="submit">
                Kirim Pesan Sekarang →
            </button>
        </form>
    </div>
</section>
@endsection