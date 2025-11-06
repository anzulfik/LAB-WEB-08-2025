@extends('layouts.app')

@section('content')

<form action="{{ route('fishes.update', $fish) }}" method="POST" 
      class="glass-form max-w-3xl mx-auto mt-10 relative space-y-6">
    @csrf
    @method('PUT')

    <a href="{{ route('fishes.index') }}" 
       class="absolute top-4 left-4 text-gray-700 hover:text-sky-600 text-2xl font-bold transition leading-none">
        &lt;
    </a>

    @if ($errors->any())
        <div class="p-4 rounded-lg border border-red-300 bg-red-200/60 text-red-800 backdrop-blur-md">
            <strong class="block font-semibold mb-2">Terjadi kesalahan:</strong>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @include('components.form', ['fish' => $fish])
</form>

@endsection
