<div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="flex items-center">
        <img class="w-10 h-10 rounded-full" src="{{ $image }}" alt="Item">
        <div class="ml-4">
            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $item }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Loué par {{ $user }}</p>
        </div>
    </div>
    <div class="text-right">
        <span class="px-2 py-1 text-xs rounded-full
        @if($status === 'confirmed') bg-green-100 text-green-800
        @elseif($status === 'pending') bg-yellow-100 text-yellow-800
        @else bg-red-100 text-red-800 @endif">
        {{ ucfirst($status) }}
        </span>
        <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $price }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dates }}</p>
    </div>
</div>
