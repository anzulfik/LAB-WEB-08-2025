@extends('layouts.master')

@section('page-id', 'kuliner')
@section('title', 'Kuliner Khas')

@section('content')

<style>
    .kuliner-carousel-wrapper {
        position: relative;
        width: 90%;
        margin: 0 auto;
        padding: 0 40px;
    }

    .kuliner-carousel-container {
        overflow-x: scroll;
        scroll-behavior: smooth;
        
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .kuliner-carousel-container::-webkit-scrollbar {
        display: none; 
    }

    .kuliner-carousel-track {
        display: flex;
        flex-wrap: nowrap; 
        gap: 20px;
        padding-bottom: 20px;
    }

    /* Card item */
    .kuliner-carousel-item {
        flex: 0 0 auto; /* Mencegah card menyusut */
        width: 300px; /* Menetapkan lebar tetap untuk setiap card */
    }

    /* Tombol Navigasi Carousel */
    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        background-color: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .carousel-button:hover:not(:disabled) {
        background-color: rgba(0, 0, 0, 0.8);
    }
    
    .carousel-button:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .carousel-button.prev {
        left: -10px; /* Posisi tombol kiri */
    }

    .carousel-button.next {
        right: -10px; /* Posisi tombol kanan */
    }
</style>
    <h2 class="kuliner-title">Kuliner Khas Batam</h2>


    <div class="kuliner-carousel-wrapper">
        
        <button class="carousel-button prev" id="carousel-prev" aria-label="Slide sebelumnya">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <div class="kuliner-carousel-container" id="carousel-container">
            <div class="kuliner-carousel-track" id="carousel-track">

            <x-card title="siput gonggong" image="images/gonggong.jpg" class="kuliner-carousel-item">
                Gonggong adalah siput laut yang merupakan kuliner khas Batam dan Kepulauan Riau, 
                bukan hewan berkaki empat. Siput ini biasanya disajikan dengan cara direbus dan 
                dinikmati dengan cocolan sambal, dengan tekstur kenyal mirip udang atau cumi. 
            </x-card>

            <x-card title="Mie Tarempa" image="images/mie-tarempa.jpeg" class="kuliner-carousel-item">
                Mie tarempa adalah hidangan mie khas Kepulauan Riau yang berasal dari Tarempa, 
                Kepulauan Anambas. Ciri khasnya adalah mie lebar yang kenyal, warna kemerahan, 
                rasa pedas manis gurih dari ikan tongkol atau tuna, serta disajikan dengan beragam 
                pilihan isian seperti daging sapi, seafood, dan tauge. Mie ini bisa dinikmati dalam 
                varian kuah, kering, atau nyemek.
            </x-card>

            <x-card title="Luti Gendang" image="images/luti-gendang.jpg" class="kuliner-carousel-item">
                Luti gendang adalah roti goreng khas dari Kepulauan Riau (terutama Batam) 
                yang berisi abon ikan atau ayam. Camilan ini memiliki tekstur renyah di luar dan lembut 
                di dalam, dengan isian gurih yang memadukan rasa manis roti dengan gurihnya isian.
            </x-card>

            <x-card title="Sop Ikan Batam" image="images/sop-ikan.jpg" class="kuliner-carousel-item">
                Sop ikan Batam adalah kuliner khas Kepulauan Riau berupa sup berkuah bening, gurih, dan
                 segar dari ikan laut segar seperti kakap atau tenggiri. Ciri khasnya adalah penggunaan
                  bumbu sederhana, seperti jahe, ebi halus, dan jeruk nipis, serta penambahan sawi asin 
                  dan tomat hijau yang memberikan rasa unik dan segar.
            </x-card>

            <x-card title="Teh Obeng" image="images/teh-obeng.jpg" class="kuliner-carousel-item">
                 Teh obeng adalah sebutan untuk es teh manis khas Batam yang berasal dari istilah bahasa 
                 Hokkien, yaitu "teh o peng" (teh hitam dengan es). Sebutan ini mengalami perubahan dialek, 
                 dari "teh apeng" (istilah Singapura untuk es teh manis) menjadi "teh obeng" karena pengaruh 
                 bahasa Melayu lokal
            </x-card>


            <x-card title="Bilis Molen" image="images/bilis-molen.jpg" class="kuliner-carousel-item">
                Bilis molen adalah camilan khas Batam, Kepulauan Riau, yang terbuat dari ikan teri (bilis) 
                yang dibungkus dengan adonan tepung lalu digoreng hingga renyah. Camilan ini memiliki rasa 
                gurih ikan asin yang berpadu dengan adonan yang sedikit manis, dan biasanya disajikan saat 
                minum teh atau kopi.
            </x-card>

        </div>
    </div>

    <button class="carousel-button next" id="carousel-next" aria-label="Slide berikutnya">
            <i class="fa-solid fa-chevron-right"></i>
    </button>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('carousel-container');
    const track = document.getElementById('carousel-track');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');

    if (container && track && prevBtn && nextBtn) {
        
        // Fungsi untuk menghitung lebar 1 slide (termasuk gap/margin)
        function getSlideWidth() {
            const firstSlide = track.querySelector('.kuliner-carousel-item');
            if (!firstSlide) return 300;

            const slideStyle = getComputedStyle(firstSlide);
            const slideWidth = firstSlide.offsetWidth;
            
            const trackStyle = getComputedStyle(track);
            const trackGap = parseFloat(trackStyle.gap) || 20;
            
            return slideWidth + trackGap;
        }

        // Fungsi untuk memperbarui status tombol (disabled/enabled)
        function updateButtonState() {
            const scrollLeft = container.scrollLeft;
            const maxScrollLeft = container.scrollWidth - container.clientWidth;
            
            prevBtn.disabled = (scrollLeft <= 0);
            
            nextBtn.disabled = (scrollLeft >= maxScrollLeft - 5);
        }

        nextBtn.addEventListener('click', () => {
            container.scrollBy({
                left: getSlideWidth(), // Geser ke kanan selebar 1 slide
                behavior: 'smooth'
            });
        });

        prevBtn.addEventListener('click', () => {
            container.scrollBy({
                left: -getSlideWidth(), // Geser ke kiri selebar 1 slide
                behavior: 'smooth'
            });
        });

        // Update status tombol setiap kali user selesai scroll
        container.addEventListener('scroll', updateButtonState);
        
        // Update status tombol saat ukuran window berubah (responsive)
        new ResizeObserver(updateButtonState).observe(container);

        // Panggil sekali saat halaman pertama kali dimuat
        updateButtonState();
    }
});
</script>
@endpush