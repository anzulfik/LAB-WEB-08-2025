@extends('layouts.master')

@section('title', 'Kontak - Eksplor Tana Toraja')

@section('content')
    <div class="relative h-96 bg-gray-800">
        <img src="{{ asset('images/kontak_hero.jpg') }}" alt="Kontak Kami" class="w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center text-white px-4">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Kontak Kami</h1>
                <p class="text-lg md:text-xl max-w-2xl">Hubungi kami jika Anda memiliki pertanyaan lebih lanjut.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        
        <div class="bg-white rounded-xl shadow-2xl p-8 md:p-12 max-w-4xl mx-auto">
            <div class="grid md:grid-cols-2 gap-10">
                
                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Informasi</h2>
                    <div class="space-y-4">
                        <p class="text-gray-700 flex items-start">
                            <span class="mt-1 mr-3 text-blue-600">&#9993;</span> <span>
                                <strong>Email:</strong><br>
                                <span class="text-blue-600">info@eksplortoraja.com</span>
                            </span>
                        </p>
                        <p class="text-gray-700 flex items-start">
                            <span class="mt-1 mr-3 text-blue-600">&#9742;</span> <span>
                                <strong>Telepon:</strong><br>
                                <span class="text-blue-600">+62 123 4567 890</span>
                            </span>
                        </p>
                        <p class="text-gray-700 flex items-start">
                             <span class="mt-1 mr-3 text-blue-600">&#9906;</span> <span>
                                <strong>Alamat:</strong><br>
                                Jalan Pariwisata No. 1, Rantepao<br>
                                Tana Toraja, Sulawesi Selatan
                            </span>
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold mb-6 text-gray-800">Kirim Pesan</h2>
                    <form action="#" method="POST" class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="email@anda.com">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                            <textarea id="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Pesan Anda"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection