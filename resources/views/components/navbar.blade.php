<header x-data="header" class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:bg-gray-900/95 dark:supports-[backdrop-filter]:bg-gray-900/60">
    <div class="container flex h-16 items-center justify-between px-4 mx-auto">
        <!-- Logo -->
        <div class="flex items-center gap-4">
            <a href="/" class="flex items-center gap-2">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-xl font-bold dark:text-white">MediaRent</span>
            </a>
            
            <!-- Barre de recherche (Desktop) -->
            <div class="hidden md:block relative w-64 ml-20">
                <input type="text" placeholder="Rechercher du matériel..." 
                       class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                <button class="absolute right-3 top-2 text-gray-500 dark:text-gray-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-4">
            @if(request()->is('/'))
                <a href="#how-it-works" class="text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors dark:text-white">Comment ça marche</a>
                <a href="#categories"  class="text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors dark:text-white">Catégories</a>
                <a href="#pricing" class="text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors dark:text-white">Tarifs</a>
                <a href="#about" class="text-sm font-medium hover:text-blue-600 dark:hover:text-blue-400 transition-colors dark:text-white">À propos</a>
            @endif
            <!-- Dark Mode Toggle -->
            @include('components.theme-toggle')
            
            <a href="/login" class="inline-flex items-center justify-center h-9 px-4 py-2 text-sm font-medium border border-blue-600 text-blue-600 dark:text-blue-400 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors">Se connecter</a>
            <a href="/register" class="inline-flex items-center justify-center h-9 px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">S'inscrire</a>
        </nav>

        <!-- Mobile Menu Button -->
        <div class="flex items-center gap-2 md:hidden">
            <!-- Barre de recherche (Mobile - Icône seulement) -->
            <button @click="mobileSearchOpen = !mobileSearchOpen" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            
            <!-- Dark Mode Toggle -->
            <button @click="toggleDarkMode()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </button>
            
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            {{-- problem in here  --}}
        </div>
    </div>

    <!-- Barre de recherche mobile (seulement visible quand activée) -->
    <div x-show="mobileSearchOpen" class="md:hidden bg-white dark:bg-gray-800 border-t p-3">
        <div class="relative">
            <input type="text" placeholder="Rechercher du matériel..." 
                   class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="absolute right-3 top-2 text-gray-500 dark:text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" class="md:hidden bg-white dark:bg-gray-900 border-t">
        <div class="container px-4 py-3 space-y-3">
            <a href="#how-it-works" @click="smoothScroll($event); mobileMenuOpen = false" class="block py-2 hover:text-blue-600 dark:hover:text-blue-400">Comment ça marche</a>
            <a href="#categories" @click="smoothScroll($event); mobileMenuOpen = false" class="block py-2 hover:text-blue-600 dark:hover:text-blue-400">Catégories</a>
            <a href="#pricing" @click="smoothScroll($event); mobileMenuOpen = false" class="block py-2 hover:text-blue-600 dark:hover:text-blue-400">Tarifs</a>
            <a href="#about" @click="smoothScroll($event); mobileMenuOpen = false" class="block py-2 hover:text-blue-600 dark:hover:text-blue-400">À propos</a>
            <div class="pt-2 space-y-2">
                <a href="/login" class="block w-full text-center py-2 border border-blue-600 text-blue-600 dark:text-blue-400 rounded-md hover:bg-blue-50 dark:hover:bg-blue-900/10">Se connecter</a>
                <a href="/register" class="block w-full text-center py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">S'inscrire</a>
            </div>
        </div>
    </div>
</header>

<!-- Alpine JS for functionality -->
