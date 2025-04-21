<div class="px-6 py-4 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="relative">
        <img class="w-10 h-10 rounded-full" src="{{ $image }}" alt="{{ $name }}">
        @if(isset($online) && $online)
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
        @endif
    </div>
    <div class="ml-4 min-w-0">
        <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $name }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $date }}</p>
    </div>
    <div class="ml-auto flex items-center">
        <span class="px-2 py-1 text-xs font-medium rounded-full bg-{{ $roleColor }}-100 text-{{ $roleColor }}-800 dark:bg-{{ $roleColor }}-900 dark:text-{{ $roleColor }}-200">
            {{ $role }}
        </span>
        
        @if(isset($dropdown) && $dropdown)
        <div class="ml-2 relative">
            <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-700">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-eye mr-2"></i> Voir profil
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-edit mr-2"></i> Modifier
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-envelope mr-2"></i> Contacter
                    </a>
                    @if($role === 'Partenaire')
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-list-alt mr-2"></i> Voir annonces
                    </a>
                    @endif
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                    <a href="#" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-ban mr-2"></i> Suspendre
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>