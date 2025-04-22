<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-800 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:relative md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-indigo-800">
        <div class="flex items-center justify-center h-16 px-4 bg-indigo-900">
            <span class="text-white font-bold text-xl">Audiovisuel Location</span>
        </div>
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <div class="space-y-1">
                <!-- Tableau de bord -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-3 text-sm font-medium text-white bg-indigo-900 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Tableau de bord
                </a>

                <!-- Utilisateurs -->
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-users mr-3"></i>
                    Utilisateurs
                </a>

                <!-- Annonces -->
                <div class="relative">
                    <button class="flex items-center justify-between w-full px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                        <span class="flex items-center">
                            <i class="fas fa-list-alt mr-3"></i>
                            Annonces
                        </span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="hidden absolute left-0 right-0 mt-1 py-1 bg-indigo-700 rounded-md shadow-lg z-10">
                        <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Toutes les annonces</a>
                        <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Annonces premium</a>
                        <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Annonces archivées</a>
                    </div>
                </div>

                <!-- Réservations -->
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-calendar-check mr-3"></i>
                    Réservations
                </a>

                <!-- Catégories -->
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-tags mr-3"></i>
                    Catégories
                </a>

                <!-- Commentaires -->
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-comments mr-3"></i>
                    Commentaires
                </a>

                <!-- Paramètres -->
                <a href="#}" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-cog mr-3"></i>
                    Paramètres
                </a>
            </div>
        </div>
        <div class="p-4 border-t border-indigo-700">
            <div class="flex items-center">
                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="Admin">
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">User authentifié</p>
                    <a href="#" class="text-xs font-medium text-indigo-300 hover:text-indigo-100">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
</div>
