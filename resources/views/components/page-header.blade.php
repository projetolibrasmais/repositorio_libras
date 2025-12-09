@props(['title', 'description' => null, 'action' => null])

<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
            @if($description)
                <p class="mt-1 text-sm text-gray-600">{{ $description }}</p>
            @endif
        </div>
        
        @if($action)
            <div class="flex-shrink-0">
                {{ $action }}
            </div>
        @endif
    </div>
</div>
