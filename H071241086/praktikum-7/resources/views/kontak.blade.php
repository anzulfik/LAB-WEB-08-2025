@extends('layouts.master')
@section('title', 'Kontak - Eksplor Bulukumba')

@section('content')
<section class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-900 text-white py-12 px-4 sm:px-6 lg:px-8 min-h-screen flex flex-col justify-center items-center overflow-hidden">
    <div class="absolute top-20 -left-20 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-float pointer-events-none"></div>
    <div class="absolute bottom-20 -right-20 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl animate-float-delayed pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>
    
    <div class="absolute top-10 right-10 w-32 h-32 bg-cyan-400/5 rounded-full blur-2xl animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-40 h-40 bg-blue-400/5 rounded-full blur-2xl animate-pulse animation-delay-1000 pointer-events-none"></div>

    <div class="relative z-20 w-full max-w-7xl mx-auto">
        
        <div class="text-center mb-8 space-y-3">
            <div class="inline-block animate-fade-in">
                <span class="inline-flex items-center gap-2 bg-gradient-to-r from-white/10 to-cyan-400/10 backdrop-blur-md border border-white/20 text-cyan-200 px-5 py-2 rounded-full text-xs font-bold shadow-xl hover:shadow-cyan-500/30 transition-all duration-300 hover:scale-105">
                    <span class="w-2 h-2 bg-cyan-400 rounded-full animate-ping absolute"></span>
                    <span class="w-2 h-2 bg-cyan-400 rounded-full"></span>
                    Mari Terhubung
                </span>
            </div>
            
         <h1 class="text-4xl md:text-5xl font-black tracking-tight pb-3 animate-fade-in-up">
            <span class="inline-block bg-gradient-to-r from-white via-cyan-100 to-blue-200 bg-clip-text text-transparent drop-shadow-[0_4px_15px_rgba(0,255,255,0.4)] leading-[1.35]">
                Hubungi Kami
            </span>
        </h1>
            
            <p class="text-sm md:text-base text-blue-100/90 max-w-2xl mx-auto leading-relaxed animate-fade-in-up animation-delay-200">
                Punya pertanyaan tentang destinasi wisata, kuliner khas, atau event menarik?
            </p>
        </div>
        <div class="grid lg:grid-cols-5 gap-6">            
            
            <div class="lg:col-span-2 space-y-5 animate-slide-in-left">  
                <div class="group bg-gradient-to-br from-white/8 to-white/5 backdrop-blur-xl border border-white/20 rounded-3xl p-6 hover:from-white/12 hover:to-white/8 hover:border-cyan-400/30 hover:shadow-2xl hover:shadow-cyan-500/20 transition-all duration-500">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                            <div class="w-5 h-5 bg-white/90 rounded-md"></div>
                        </div>
                        <h3 class="text-xl font-black text-white">Informasi Kontak</h3>
                    </div>
                    
                    <div class="space-y-5">
                        <div class="group/item flex gap-3.5 items-start hover:translate-x-1 transition-all duration-300">
                            <div class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-cyan-500/20 to-blue-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 border border-cyan-400/20">
                                <div class="w-5 h-5 bg-gradient-to-br from-cyan-400 to-blue-400 rounded-lg shadow-inner"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-cyan-300 text-[11px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1 h-1 bg-cyan-400 rounded-full"></span>
                                    Alamat
                                </p>
                                <p class="text-white/95 text-sm leading-relaxed font-medium">
                                    Jl. Jenderal Sudirman No.45<br/>
                                    Bulukumba, Sulawesi Selatan
                                </p>
                            </div>
                        </div>

                        <div class="group/item flex gap-3.5 items-start hover:translate-x-1 transition-all duration-300">
                            <div class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-cyan-500/20 to-blue-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 border border-cyan-400/20">
                                <div class="w-5 h-5 border-2 border-cyan-400 rounded-md shadow-inner"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-cyan-300 text-[11px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1 h-1 bg-cyan-400 rounded-full"></span>
                                    Email
                                </p>
                                <a href="mailto:diskominfo@bulukumbakab.go.id" class="text-white/95 text-sm hover:text-cyan-300 transition-colors break-all font-medium underline decoration-cyan-500/30 hover:decoration-cyan-300">
                                    diskominfo@bulukumbakab.go.id
                                </a>
                            </div>
                        </div>
                        <div class="group/item flex gap-3.5 items-start hover:translate-x-1 transition-all duration-300">
                            <div class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-cyan-500/20 to-blue-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 border border-cyan-400/20">
                                <div class="w-5 h-5 border-2 border-cyan-400 rounded-full shadow-inner"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-cyan-300 text-[11px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1 h-1 bg-cyan-400 rounded-full"></span>
                                    Telepon
                                </p>
                                <a href="tel:0413810 04" class="text-white text-lg font-bold hover:text-cyan-300 transition-colors">
                                    0413 81004
                                </a>
                            </div>
                        </div>

                        <div class="group/item flex gap-3.5 items-start hover:translate-x-1 transition-all duration-300">
                            <div class="flex-shrink-0 w-11 h-11 bg-gradient-to-br from-purple-500/20 to-pink-500/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-300 border border-purple-400/20">
                                <div class="w-5 h-5 bg-gradient-to-br from-purple-400 to-pink-400 rounded-lg shadow-inner"></div>
                            </div>
                            <div class="flex-1">
                                <p class="text-purple-300 text-[11px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1 h-1 bg-purple-400 rounded-full"></span>
                                    Instagram
                                </p>
                                <a href="https://instagram.com/iinfobulukumba" target="_blank" class="text-white/95 text-sm hover:text-pink-300 transition-colors font-medium">
                                    @iinfobulukumba
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-cyan-500/15 to-blue-600/15 backdrop-blur-xl border border-cyan-400/30 rounded-2xl p-5 hover:shadow-xl hover:shadow-cyan-500/20 transition-all duration-500 animate-slide-in-left animation-delay-200">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-cyan-400/20 rounded-xl flex items-center justify-center flex-shrink-0">
                            <div class="w-5 h-5 bg-cyan-400 rounded-full animate-pulse"></div>
                        </div>
                        <div>
                            <h4 class="font-bold text-cyan-200 mb-1.5 text-sm">Respon Cepat</h4>
                            <p class="text-xs text-blue-100/80 leading-relaxed">
                                Kami merespons dalam <span class="text-cyan-300 font-bold">1-2 hari kerja</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 animate-slide-in-right">
                <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-7 hover:shadow-cyan-500/20 transition-all duration-500 max-w-2xl">
                    
                    <div class="mb-5 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl shadow-xl mb-3">
                            <span class="text-2xl">✉️</span>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-black text-gray-900 mb-2">Kirim Pesan</h2>
                        <p class="text-xs text-gray-600">Isi formulir di bawah dan kami akan segera menghubungi Anda</p>
                    </div>

                    <form class="space-y-3.5">
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                placeholder="Masukkan nama lengkap Anda"
                                class="w-full px-4 py-2.5 text-sm bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-400 hover:border-gray-300 font-medium"
                            />
                        </div>
                        <div class="grid md:grid-cols-2 gap-3.5">
                            <div class="group">
                                <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    placeholder="nama@email.com"
                                    class="w-full px-4 py-2.5 text-sm bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-400 hover:border-gray-300 font-medium"
                                />
                            </div>

                            <div class="group">
                                <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Nomor Telepon
                                </label>
                                <input 
                                    type="tel" 
                                    placeholder="08xx xxxx xxxx"
                                    class="w-full px-4 py-2.5 text-sm bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-400 hover:border-gray-300 font-medium"
                                />
                            </div>
                        </div>
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                Kategori Pertanyaan
                            </label>
                            <select class="w-full px-4 py-2.5 text-sm bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 outline-none transition-all duration-300 text-gray-900 hover:border-gray-300 font-medium">
                                <option value="">Pilih kategori...</option>
                                <option value="wisata">Destinasi Wisata</option>
                                <option value="kuliner">Kuliner Khas</option>
                                <option value="event">Event & Acara</option>
                                <option value="penginapan">Akomodasi & Penginapan</option>
                                <option value="transportasi">Transportasi</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="group">
                            <label class="block text-xs font-bold text-gray-800 mb-1.5 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-cyan-500 rounded-full"></span>
                                Pesan Anda <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                placeholder="Ceritakan kebutuhan atau pertanyaan Anda..."
                                rows="3"
                                class="w-full p-4 text-sm bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 outline-none resize-none transition-all duration-300 text-gray-900 placeholder:text-gray-400 hover:border-gray-300 font-medium"
                            ></textarea>
                        </div>

                        <div class="pt-2">
                            <button 
                                type="submit"
                                class="group relative w-full bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-600 text-white font-black text-sm px-6 py-3.5 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-cyan-500/40 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]"
                            >
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    Kirim Pesan Sekarang
                                    <span class="group-hover:translate-x-1 transition-transform duration-300 text-lg">→</span>
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </button>
                        </div>

                        <p class="text-[10px] text-center text-gray-500 pt-1 flex items-center justify-center gap-1.5">
                            <span class="w-3 h-3 text-xs"></span>
                            Data Anda aman dan terlindungi
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-slate-950/80 to-transparent pointer-events-none"></div>
</section>
@endsection