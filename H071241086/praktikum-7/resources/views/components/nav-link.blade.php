@props(['href', 'active' => false])

@php
$classes = $active
    ? 'text-yellow-300 border-b-2 border-yellow-300 transition duration-300'
    : 'hover:text-yellow-300 transition duration-300';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'px-3 py-2 ' . $classes]) }}>
    {{ $slot }}
</a>