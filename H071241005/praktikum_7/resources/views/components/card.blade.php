@props(['imgSrc', 'tag' => false, 'title', 'description'])

<div class="bg-white rounded-lg shadow-lg overflow-hidden group transition-all duration-300 hover:shadow-2xl">
    <div class="relative">
        <img src="{{ asset('images/' . $imgSrc) }}" alt="{{ $title }}" class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-500">
        
        @if ($tag)
            <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs font-bold uppercase px-3 py-1 rounded-full">{{ $tag }}</div>
        @endif
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $title }}</h3>
        <p class="text-gray-600 text-sm leading-relaxed">{{ $description }}</p>
    </div>
</div>