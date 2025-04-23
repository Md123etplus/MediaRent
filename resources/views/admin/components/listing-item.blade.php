<div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $title }}</p>
                <span class="px-2 py-1 text-xs font-medium rounded-full
                    @if($status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @elseif($status === 'Expired') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                    @elseif($status === 'Rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @endif">
                    {{ $status }}
                </span>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                <span class="font-medium">{{ $location }}</span> - {{ $price }}
            </p>

            <div class="mt-2 flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400">
                <span>{{ $date }}</span>
                <span class="mx-2 hidden sm:inline">•</span>
                <span class="mt-1 sm:mt-0">{{ $reservations }}</span>

                @if(isset($premium) && $premium)
                <span class="ml-2 px-1.5 py-0.5 text-xs rounded bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    <i class="fas fa-crown mr-1"></i> Premium
                </span>
                @endif
            </div>
        </div>

        <div class="ml-4 flex-shrink-0">
            <img class="h-12 w-12 rounded-md object-cover" src="{{ $thumbnail ?? 'https://via.placeholder.com/48' }}" alt="{{ $title }}">
        </div>
    </div>

    @if(isset($actions) && $actions)
    <div class="mt-3 flex justify-end space-x-2">
        <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800 rounded" title="Voir">
            <i class="fas fa-eye mr-1"></i> Voir
        </button>
        <button class="px-3 py-1 text-xs bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded" title="Approuver">
            <i class="fas fa-check mr-1"></i> Approuver
        </button>
        <button class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-200 dark:hover:bg-yellow-800 rounded" title="Modifier">
            <i class="fas fa-edit mr-1"></i> Modifier
        </button>
        <button class="px-3 py-1 text-xs bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 rounded" title="Supprimer">
            <i class="fas fa-trash mr-1"></i> Supprimer
        </button>
    </div>
    @endif
</div>
