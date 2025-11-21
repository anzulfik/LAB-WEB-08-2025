@extends('layouts.app')
@section('title', $category->name)

@section('content')
<div class="relative w-full min-h-screen pt-32 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Kategori.png') }}');">
    <div class="max-w-3xl mx-auto">
        <div class="relative glass-container p-8">
            <a href="{{ route('categories.index') }}"
            class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 text-2xl font-bold">
                &lt;
            </a>

            <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">
                {{ $category->name }}
            </h2>

            <div class="space-y-4 text-gray-800">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <div class="px-3 py-2 rounded-lg border border-white/40 bg-white/50 backdrop-blur-md shadow-sm">
                        {{ $category->description ?: 'Tidak ada deskripsi' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
