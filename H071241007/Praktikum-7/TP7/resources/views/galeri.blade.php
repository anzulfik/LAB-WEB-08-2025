@extends('layouts.master')

@section('page-id', 'gallery-page')
@section('main-class', 'gallery-container')
@section('title', 'Galeri')

@section('content')
    <img src="{{ asset('images/galeri1.jpg') }}" alt="Galeri Welcom batam" class="gallery-image" data-aos="fade-up">
   
    <img src="{{ asset('images/galeri2.jpg') }}" alt="Galeri random image batam" class="gallery-image" data-aos="fade-up">

    <img src="{{ asset('images/galeri3.jpg') }}" alt="Galeri random image sunrise shit batam" class="gallery-image" data-aos="fade-up">

    <img src="{{ asset('images/galeri4.jpg') }}" alt="Galeri jembatan barelang" class="gallery-image" data-aos="fade-up">

    <img src="{{ asset('images/galeri5.jpg') }}" alt="Galeri city scape shit" class="gallery-image" data-aos="fade-up">

    <img src="{{ asset('images/galeri6.jpg') }}" alt="Galeri random kidz running" class="gallery-image" data-aos="fade-up">
    
@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.gallery-image');
    
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) + 150 &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }
    
    function checkImages() {
        images.forEach(function(image) {
            if (isInViewport(image)) {
                image.classList.add('aos-animate');
            }
        });
    }
    
    //animasi
    window.addEventListener('scroll', checkImages);

    checkImages();
});
</script>
@endpush