@props(['title', 'action' => null])

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
    @if($action)
        <div>
            {{ $action }}
        </div>
    @endif
</div>