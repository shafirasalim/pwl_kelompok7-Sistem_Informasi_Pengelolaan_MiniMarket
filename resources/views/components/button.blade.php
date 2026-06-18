@props(['type' => 'button', 'variant' => 'primary', 'href' => null])

@php
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700',
        'secondary' => 'bg-gray-300 text-gray-700 hover:bg-gray-400',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
    ];
    $class = $variants[$variant] ?? $variants['primary'];
@endphp

@if($href)
    <a href="{{ $href }}" 
       {{ $attributes->merge(['class' => "inline-block px-4 py-2 rounded font-medium transition $class"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" 
            {{ $attributes->merge(['class' => "px-4 py-2 rounded font-medium transition $class"]) }}>
        {{ $slot }}
    </button>
@endif