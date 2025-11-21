@extends('layouts.app')
@section('title', 'Tambah Gudang')

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Gudang.png') }}');">
    <div class="max-w-3xl mx-auto pt-28 pb-24">
        <div class="relative glass-container p-8">
            <a href="{{ route('warehouses.index') }}" 
            class="absolute top-4 left-4 text-blue-700 hover:text-blue-900 text-2xl font-bold">&lt;</a>

            <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">
                Tambah Gudang
            </h2>
            @include('components.formware', ['warehouse' => null])
        </div>
    </div>
</div>
@endsection
