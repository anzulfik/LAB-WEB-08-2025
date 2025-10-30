<div class="rounded-3xl overflow-hidden shadow-2xl bg-white hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-2 w-full max-w-sm">
    <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="w-full h-56 object-cover">
    <div class="p-5">
        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $title }}</h3>
        <p class="text-gray-600 text-sm leading-relaxed">{{ $description }}</p>
    </div>
</div>
