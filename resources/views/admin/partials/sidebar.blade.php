<div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-indigo-800 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:relative md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-indigo-800">
        <div class="flex items-center justify-center h-16 px-4 bg-indigo-900">
            <span class="text-white font-bold text-xl">Audiovisuel Location</span>
        </div>
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <div class="space-y-1">
                <!-- Tableau de bord -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Tableau de bord
                </a>

                <!-- Utilisateurs -->
                <a href="{{  route('admin.users.index') }}" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-users mr-3"></i>
                    Utilisateurs
                </a>

                <!-- Annonces -->
                <div class="relative">
                    <button id="annonces-menu-button" class="flex items-center justify-between w-full px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                        <span class="flex items-center">
                            <i class="fas fa-list-alt mr-3"></i>
                            Annonces
                        </span>
                        <i id="annonces-chevron" class="fas fa-chevron-down transition-transform duration-200"></i>
                    </button>
                    <div id="annonces-menu" class="hidden absolute left-0 right-0 mt-1 py-1 bg-indigo-700 rounded-md shadow-lg z-10">
                        <a href="{{ route('admin.annonces.index', 'all') }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Toutes les annonces</a>
                        <a href="{{ route('admin.annonces.index', 'premium') }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Annonces premium</a>
                        <a href="{{ route('admin.annonces.index', 'Archivée') }}" class="block px-4 py-2 text-sm text-white hover:bg-indigo-600">Annonces archivées</a>
                    </div>
                </div>

                <!-- Réservations -->
                <a href="{{ route('admin.reservations.index') }}" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-calendar-check mr-3"></i>
                    Réservations
                </a>

                <!-- Catégories -->
                {{-- <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-tags mr-3"></i>
                    Catégories
                </a> --}}

                <!-- Commentaires -->
                <a href="{{ route('admin.evaluations.index') }}" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-700 rounded-lg">
                    <i class="fas fa-comments mr-3"></i>
                    Commentaires
                </a>

                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="export-dropdown-button"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 flex items-center">
                            <i class="fas fa-file-export mr-2"></i>
                            Exporter les données
                        </button>

                        <div id="export-dropdown" class="hidden absolute right-0 mt-2 w-56 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10">
                            <div class="py-1">
                                <a href="{{ route('admin.export', ['type' => 'users']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Utilisateurs
                                </a>
                                <a href="{{ route('admin.export', ['type' => 'annonces']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Annonces
                                </a>
                                <a href="{{ route('admin.export', ['type' => 'reservations']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Réservations
                                </a>
                                <a href="{{ route('admin.export', ['type' => 'evaluations']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                                    Évaluations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 border-t border-indigo-700">
            <div class="flex items-center">
                <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/40" alt="Admin">
                <div class="ml-3">
                    <p class="text-sm font-medium text-white">User authentifié</p>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-indigo-300 hover:text-indigo-100 focus:outline-none">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('export-dropdown-button').addEventListener('click', function() {
        document.getElementById('export-dropdown').classList.toggle('hidden');
    });

    // Fermer le dropdown quand on clique ailleurs
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('export-dropdown');
        const button = document.getElementById('export-dropdown-button');

        if (!dropdown.contains(event.target) && event.target !== button) {
            dropdown.classList.add('hidden');
        }
    });

    // Highlight du lien actif dans la sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.href;
        const navLinks = document.querySelectorAll('#sidebar a:not([href="{{ route('admin.logout') }}"])');

        navLinks.forEach(link => {
            if (link.href === currentUrl ||
                (link.href.includes('admin/annonces') && currentUrl.includes('admin/annonces'))) {
                // Pour le lien actif
                link.classList.remove('text-indigo-200', 'hover:text-white', 'hover:bg-indigo-700');
                link.classList.add('text-white', 'bg-indigo-900');

                // Si c'est un sous-menu, on highlight aussi le parent
                if (link.parentElement.parentElement.id === 'annonces-menu') {
                    document.getElementById('annonces-menu-button').classList.remove('text-indigo-200', 'hover:text-white', 'hover:bg-indigo-700');
                    document.getElementById('annonces-menu-button').classList.add('text-white', 'bg-indigo-900');
                }
            }
        });
    });
</script>
@endpush
