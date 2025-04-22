<div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <img class="w-8 h-8 rounded-full" src="{{ $image }}" alt="{{ $user }}">
            <p class="ml-3 text-sm font-medium text-gray-800 dark:text-white">{{ $user }}</p>
        </div>
        <div class="flex">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $rating)
                    <i class="fas fa-star text-yellow-400"></i>
                @else
                    <i class="far fa-star text-yellow-400"></i>
                @endif
            @endfor
        </div>
    </div>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">"{{ $comment }}"</p>
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Sur {{ $item }} - {{ $date }}</p>
    
    @if(isset($actions) && $actions)
    <div class="mt-3 flex justify-end space-x-2">
        <button class="px-3 py-1 text-xs bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded" title="Approuver">
            <i class="fas fa-check mr-1"></i> Approuver
        </button>
        <button class="px-3 py-1 text-xs bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 rounded" title="Rejeter">
            <i class="fas fa-times mr-1"></i> Rejeter
        </button>
        <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800 rounded" title="Modérer">
            <i class="fas fa-edit mr-1"></i> Modérer
        </button>
    </div>
    @endif
</div>