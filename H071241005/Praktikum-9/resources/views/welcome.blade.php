@extends('layouts.app')

@section('content')
{{-- Custom CSS untuk efek Scanline dan Animasi Kedip --}}
<style>
    .scanlines {
        background: linear-gradient(
            to bottom,
            rgba(255,255,255,0),
            rgba(255,255,255,0) 50%,
            rgba(0,0,0,0.2) 50%,
            rgba(0,0,0,0.2)
        );
        background-size: 100% 4px;
        animation: scroll 10s linear infinite; 
        pointer-events: none;
    }
    .blink { animation: blinker 1s linear infinite; }
    @keyframes blinker { 50% { opacity: 0; } }
    
    /* Text Glow Effect */
    .neon-text {
        text-shadow: 0 0 5px rgba(6, 182, 212, 0.7), 
                     0 0 10px rgba(6, 182, 212, 0.5);
    }
</style>

<div class="relative min-h-screen flex items-center justify-center bg-gray-900 overflow-hidden font-mono">
    
    {{-- Background Image dengan Filter Cyberpunk --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/gudang.jpg') }}" alt="Warehouse Background" 
             class="w-full h-full object-cover opacity-10 grayscale contrast-125 mix-blend-luminosity">
        {{-- Overlay Warna Cyberpunk --}}
        <div class="absolute inset-0 bg-gradient-to-b from-cyan-900/30 to-purple-900/30 mix-blend-overlay"></div>
        {{-- Grid Overlay --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImEiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTTAgNDBWMGg0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDYsIDE4MiwgMjEyLCAwLjEpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjYSkiLz48L3N2Zz4=')]"></div>
        {{-- Scanline Effect --}}
        <div class="absolute inset-0 scanlines z-20"></div>
        {{-- Vignette --}}
        <div class="absolute inset-0 bg-radial-gradient from-transparent to-black opacity-90"></div>
    </div>

    {{-- Main Content --}}
    <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        
        <div class="flex flex-col items-center justify-center">
            
            {{-- Decorative HUD Elements Top --}}
            <div class="w-full max-w-4xl flex justify-between text-xs text-cyan-500 mb-2 opacity-70 tracking-widest">
                <span>SYS.VER.2.0.77</span>
                <span class="blink">Connection: SECURE</span>
            </div>

            {{-- Main Terminal Box --}}
            <div class="relative group">
                {{-- Border Glow Container --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 via-purple-500 to-pink-500 rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                
                <div class="relative bg-black/80 border border-cyan-500/50 backdrop-blur-sm p-8 md:p-12 rounded-lg shadow-[0_0_50px_rgba(6,182,212,0.15)] clip-path-polygon">
                    
                    {{-- Decorative Corner Accents --}}
                    <div class="absolute top-0 left-0 w-4 h-4 border-t-2 border-l-2 border-cyan-400"></div>
                    <div class="absolute top-0 right-0 w-4 h-4 border-t-2 border-r-2 border-cyan-400"></div>
                    <div class="absolute bottom-0 left-0 w-4 h-4 border-b-2 border-l-2 border-pink-500"></div>
                    <div class="absolute bottom-0 right-0 w-4 h-4 border-b-2 border-r-2 border-pink-500"></div>

                    {{-- Content --}}
                    <div class="text-center">
                        <div class="inline-block mb-4 px-3 py-1 border border-pink-500/50 text-pink-500 text-xs tracking-[0.2em] bg-pink-900/20 rounded">
                            SYSTEM ALERT // OPTIMIZATION REQUIRED
                        </div>

                        <h1 class="neon-text text-3xl md:text-5xl lg:text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-white tracking-tight mb-6 uppercase">
                            Great Products<br>
                            <span class="text-cyan-400">Deserve Great</span><br>
                            Management_
                        </h1>

                        <div class="h-px w-24 bg-gradient-to-r from-transparent via-cyan-500 to-transparent mx-auto mb-6"></div>

                        <p class='text-cyan-100/80 text-lg md:text-xl tracking-wide'>
                            <span class="text-cyan-500 mr-2">>></span> Simple tools. Strong results.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Decorative HUD Elements Bottom --}}
            <div class="mt-8 flex gap-4">
                 <button class="px-8 py-3 bg-cyan-900/30 border border-cyan-500 text-cyan-400 hover:bg-cyan-500 hover:text-black transition-all duration-300 uppercase tracking-wider text-sm font-bold shadow-[0_0_10px_rgba(6,182,212,0.3)] hover:shadow-[0_0_20px_rgba(6,182,212,0.6)]">
                    Initialize System
                 </button>
            </div>

        </div>

    </div>
</div>
@endsection