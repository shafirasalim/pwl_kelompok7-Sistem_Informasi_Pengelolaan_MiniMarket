@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border-blue-400 text-blue-700',
    ];
    $class = $styles[$type] ?? $styles['success'];
@endphp

@if(session($type))
    <div {{ $attributes->merge(['class' => "border-l-4 p-4 mb-4 rounded $class"]) }}>
        {{ session($type) }}
    </div>
@endif

@if($errors->any() && $type === 'error')
    <div {{ $attributes->merge(['class' => "border-l-4 p-4 mb-4 rounded $class"]) }}>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif