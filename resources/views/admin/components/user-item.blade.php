<div class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="flex-shrink-0">
        <img class="w-10 h-10 rounded-full" src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="ml-4 flex-1 min-w-0">
        <div class="flex justify-between">
            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                {{ $name }}
                <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-{{ $roleColor }}-100 text-{{ $roleColor }}-800">{{ $role }}</span>
                @if($status === 'suspended' || $isSuspended)
                    <span class="ml-2 px-2 py-0.5 rounded-full bg-red-100 text-red-800">Suspendu</span>
                @endif
            </p>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $reservations }} réservations
            </div>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $email }}</p>
        <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
            <span>{{ $date }}</span>
        </div>
    </div>
    <div class="ml-4">
        <form action="{{ route('admin.users.toggle-suspension', $id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-3 py-1 text-xs rounded-md {{ $isSuspended ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}">
                {{ $isSuspended ? 'Activer' : 'Suspendre' }}
            </button>
        </form>
    </div>
</div>