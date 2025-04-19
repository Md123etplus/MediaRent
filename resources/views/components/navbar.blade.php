<header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur dark:bg-gray-900/80">
    <div class="container flex h-16 items-center justify-between">
        <div class="flex items-center gap-2">
            <a href="/" class="flex items-center gap-2">
                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <!-- Icône caméra -->
                </svg>
                <span class="text-xl font-bold">MediaRent</span>
            </a>
        </div>

        <nav class="hidden md:flex items-center gap-6">
            @foreach([
                'Matériel' => '#',
                'Comment ça marche' => '#how-it-works',
                'Tarifs' => '#pricing',
                'À propos' => '#about'
            ] as $text => $url)
                <a href="{{ $url }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors">
                    {{ $text }}
                </a>
            @endforeach
            
            <a href="/login" class="px-4 py-2 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50 dark:border-blue-400 dark:text-blue-400 dark:hover:bg-blue-900/20">
                Se connecter
            </a>
            <a href="/register" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                S'inscrire
            </a>
        </nav>

        @include('components.theme-toggle')
    </div>
</header>