@props([
    'title',
    'value',
    'icon',
    'trend' => null,
    'trendColor' => null,
    'description'
])

@php
    $trendColorClass = $trendColor ? 'text-'.$trendColor.'-500 dark:text-'.$trendColor.'-400' : 'text-gray-500 dark:text-gray-400';
    $bgColorClass = $trendColor ? 'bg-'.$trendColor.'-100 dark:bg-'.$trendColor.'-900' : 'bg-gray-100 dark:bg-gray-700';
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $value }}</p>
            @if($trend)
                <div class="flex items-center mt-2">
                    <span class="{{ $trendColorClass }} text-sm font-medium">
                        {{ $trend }}
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-1">{{ $description }}</span>
                </div>
            @else
                <span class="text-gray-500 dark:text-gray-400 text-sm mt-2">{{ $description }}</span>
            @endif
        </div>
        <div class="p-3 rounded-full {{ $bgColorClass }} {{ $trendColorClass }}">
            <i class="fas fa-{{ $icon }} text-lg"></i>
        </div>
    </div>
</div>
