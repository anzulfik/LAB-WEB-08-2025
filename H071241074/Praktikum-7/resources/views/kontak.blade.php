@extends('layouts.master')

@section('title', 'Kontak')

@section('content')
    <div class="relative min-h-screen -mt-28 flex items-center justify-center">
        <div class="absolute inset-0 bg-cover bg-center -z-10 opacity-70" style="background-image: url('{{ asset('images/awan.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/kalelawar.png') }}');">
        </div>

        <div class="absolute inset-0 bg-cover bg-center pointer-events-none" style="background-image: url('{{ asset('images/pohon-kalong.png') }}');">
        </div>

        <div class="bg-white/70 backdrop-blur-sm rounded-3xl shadow-2xl p-12 w-full max-w-7xl flex justify-between space-x-10 mt-28 tracking-wider">
            <div class="w-1/3 space-y-8 pr-10 border-r border-gray-200">
                <h2 class="text-4xl font-bold text-gray-800  mb-6">Hubungi Kami</h2>
                
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/icon-loc.png') }}" alt="Lokasi" class="w-10 h-10 mt-1">
                    <div>
                        <p class="font-semibold text-gray-700">Alamat</p>
                        <p class="text-gray-500 text-sm">Jl. Pengayoman, Watansoppeng, Sulawesi Selatan, Indonesia.</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/icon-email.png') }}" alt="Email" class="w-10 h-10 mt-1">
                    <div>
                        <p class="font-semibold text-gray-700">Email</p>
                        <p class="text-blue-900 text-sm">infosoppeng@gmail.com</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/icon-telp.png') }}" alt="Telepon" class="w-10 h-10 mt-1">
                    <div>
                        <p class="font-semibold text-gray-700">Telepon</p>
                        <p class="text-gray-500 text-sm">(1234) 56789</p>
                    </div>
                </div>
            </div>

            <div class="w-2/3 tracking-wider">
                <h2 class="text-4xl font-bold text-gray-800  mb-8">Kirim Pesan</h2>
                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label for="nama" class=" text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" required 
                               class="mt-1  w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label for="email" class=" text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" required 
                               class="mt-1  w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label for="pesan" class=" text-sm font-medium text-gray-700">Pesan Anda</label>
                        <textarea name="pesan" id="pesan" rows="4" required
                                  class="mt-1  w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm"></textarea>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-lg text-white bg-blue-900/60 hover:bg-blue-900 transition duration-150">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection