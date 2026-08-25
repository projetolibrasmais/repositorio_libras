@props(['column' => null, 'sortable' => true, 'currentSort' => null, 'currentDirection' => 'asc'])

@php
    $isSorted = $column && $currentSort === $column;
    $nextDirection = $isSorted && $currentDirection === 'asc' ? 'desc' : 'asc';
    $url = $column ? request()->fullUrlWithQuery(['sort' => $column, 'direction' => $nextDirection]) : '#';
@endphp

<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
    @if($sortable)
        <a href="{{ $url }}" class="group inline-flex items-center gap-1 hover:text-gray-700 transition-colors">
            {{ $slot }}
            <span class="flex flex-col">
                @if($isSorted && $currentDirection === 'asc')
                    <i class="ph ph-caret-up text-brand-600 -mb-1"></i>
                    <i class="ph ph-caret-down text-gray-300 -mt-1"></i>
                @elseif($isSorted && $currentDirection === 'desc')
                    <i class="ph ph-caret-up text-gray-300 -mb-1"></i>
                    <i class="ph ph-caret-down text-brand-600 -mt-1"></i>
                @else
                    <i class="ph ph-caret-up text-gray-300 group-hover:text-gray-400 -mb-1"></i>
                    <i class="ph ph-caret-down text-gray-300 group-hover:text-gray-400 -mt-1"></i>
                @endif
            </span>
        </a>
    @else
        {{ $slot }}
    @endif
</th>
