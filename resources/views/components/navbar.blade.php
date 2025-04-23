<header class="sticky top-0 z-50 w-full border-b bg-white/95 backdrop-blur">
  <div class="container mx-auto px-4 py-3">
    <!-- Barre de recherche principale -->
    <div class="flex items-center gap-4">
      <!-- Logo -->
      <a href="/" class="flex items-center gap-2 shrink-0">
        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <span class="text-xl font-bold">MediaRent</span>
      </a>
      
      <!-- Barre de recherche -->
      <div class="relative flex-1">
        <input type="text" placeholder="Rechercher du matériel..." 
               class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button class="absolute right-3 top-2 text-gray-500">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </button>
      </div>
      
      <!-- Liens navigation -->
      <nav class="bloc md:flex items-center gap-4 ml-4">
       
        <a href="/login" class="text-sm font-medium py-2 px-4 border border-blue-600 text-blue-600 rounded-md hover:bg-blue-50">Se connecter</a>
        <a href="/register" class="text-sm font-medium py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">S'inscrire</a>
      </nav>
    </div>
    
    <!-- Filtres sous forme de boutons dropdown -->
    <div class="flex flex-wrap gap-3 mt-3 pb-2">
      <!-- Filtre Catégorie -->
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
          Catégorie
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="absolute z-10 hidden group-hover:block mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg">
          <a href="?category=camera" class="block px-4 py-2 text-sm hover:bg-gray-100">Caméras</a>
          <a href="?category=audio" class="block px-4 py-2 text-sm hover:bg-gray-100">Audio</a>
          <a href="?category=light" class="block px-4 py-2 text-sm hover:bg-gray-100">Éclairage</a>
        </div>
      </div>
      
      <!-- Filtre Prix max -->
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
          Prix max
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="absolute z-10 hidden group-hover:block mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg">
          <a href="?price=50" class="block px-4 py-2 text-sm hover:bg-gray-100">Moins de 50€</a>
          <a href="?price=100" class="block px-4 py-2 text-sm hover:bg-gray-100">Moins de 100€</a>
          <a href="?price=200" class="block px-4 py-2 text-sm hover:bg-gray-100">Moins de 200€</a>
        </div>
      </div>
      
      <!-- Filtre Note min -->
      <div class="relative group">
        <button class="flex items-center gap-1 px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
          Note min
          <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="absolute z-10 hidden group-hover:block mt-1 w-48 bg-white border border-gray-200 rounded-md shadow-lg">
          <a href="?rating=3" class="block px-4 py-2 text-sm hover:bg-gray-100">3 étoiles +</a>
          <a href="?rating=4" class="block px-4 py-2 text-sm hover:bg-gray-100">4 étoiles +</a>
          <a href="?rating=5" class="block px-4 py-2 text-sm hover:bg-gray-100">5 étoiles</a>
        </div>
      </div>
    </div>
  </div>
</header>