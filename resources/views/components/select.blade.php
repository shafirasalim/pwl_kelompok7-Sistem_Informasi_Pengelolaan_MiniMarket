@props(['name', 'label' => null, 'value' => null])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif
    
    <select id="{{ $name }}" 
            name="{{ $name }}" 
            {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500']) }}>
        {{ $slot }}
    </select>
    
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>