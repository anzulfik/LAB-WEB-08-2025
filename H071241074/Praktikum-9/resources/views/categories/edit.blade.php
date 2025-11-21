@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')

<div class="relative w-full min-h-screen pt-32 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Kategori.png') }}');">
    <div class="max-w-3xl mx-auto px-3">
        <div class="relative glass-container p-8 rounded-2xl shadow-xl">

            <a href="{{ route('categories.index') }}" 
               class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 font-semibold text-2xl leading-none">
                &lt;
            </a>

            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                Edit Kategori
            </h2>

            @include('components.formctg', ['category' => $category])
        </div>
    </div>
</div>

@endsection
