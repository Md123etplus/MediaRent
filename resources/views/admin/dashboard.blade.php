@extends('admin.layouts.admin')

@section('content')
    <!-- Main Content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top navigation -->
        <div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
            <div class="flex items-center">
                <!-- Bouton du menu -->
                <button id="mobile-menu-button" class="text-gray-500 focus:outline-none md:hidden">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative mx-4">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" class="w-full py-2 pl-10 pr-4 text-sm text-gray-700 bg-gray-100 border border-transparent rounded-lg focus:bg-white focus:border-indigo-500 focus:outline-none" placeholder="Rechercher...">
                </div>
            </div>
            <div class="flex items-center">
                <button class="p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="ml-4">
                    <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/32" alt="User">
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="flex-1 overflow-auto p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tableau de bord</h1>
                <p class="text-gray-600 dark:text-gray-300">Bienvenue dans l'administration de la plateforme</p>
            </div>

            <!-- Stats cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                @include('admin.components.stats-card', [
                    'title' => 'Utilisateurs',
                    'value' => '1,248',
                    'icon' => 'users',
                    'trend' => '+12.5%',
                    'trendColor' => 'green',
                    'description' => 'depuis le mois dernier'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Annonces',
                    'value' => '356',
                    'icon' => 'list-alt',
                    'trend' => '+8.3%',
                    'trendColor' => 'green',
                    'description' => 'depuis le mois dernier'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Réservations',
                    'value' => '1,024',
                    'icon' => 'calendar-check',
                    'trend' => '-2.4%',
                    'trendColor' => 'red',
                    'description' => 'depuis le mois dernier'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Revenus',
                    'value' => '€24,780',
                    'icon' => 'euro-sign',
                    'trend' => '+5.7%',
                    'trendColor' => 'green',
                    'description' => 'depuis le mois dernier'
                ])
            </div>

            <!-- Recent activity and stats -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Recent reservations -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Réservations récentes</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @include('admin.components.reservation-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'item' => 'Caméra Sony A7 III',
                            'user' => 'Jean Dupont',
                            'price' => '€45/jour',
                            'dates' => '12-15 mai 2025'
                        ])

                        @include('admin.components.reservation-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'item' => 'Micro Rode NTG',
                            'user' => 'Marie Martin',
                            'price' => '€20/jour',
                            'dates' => '10-12 mai 2025'
                        ])

                        @include('admin.components.reservation-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'item' => 'Trépied Manfrotto',
                            'user' => 'Pierre Lambert',
                            'price' => '€15/jour',
                            'dates' => '8-10 mai 2025'
                        ])

                        @include('admin.components.reservation-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'item' => 'Éclairage LED',
                            'user' => 'Sophie Leroy',
                            'price' => '€30/jour',
                            'dates' => '5-8 mai 2025'
                        ])
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir toutes les réservations</a>
                    </div>
                </div>

                <!-- Recent reviews -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Avis récents</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @include('admin.components.review-item', [
                            'image' => 'https://via.placeholder.com/32',
                            'user' => 'Jean Dupont',
                            'rating' => 4,
                            'comment' => 'Très bon matériel, exactement comme décrit. Le propriétaire était très sympathique et arrangeant.',
                            'item' => 'Caméra Sony A7 III',
                            'date' => '14 mai 2025'
                        ])

                        @include('admin.components.review-item', [
                            'image' => 'https://via.placeholder.com/32',
                            'user' => 'Marie Martin',
                            'rating' => 5,
                            'comment' => 'Parfait pour mon tournage. Je recommande ce matériel et ce propriétaire!',
                            'item' => 'Micro Rode NTG',
                            'date' => '13 mai 2025'
                        ])

                        @include('admin.components.review-item', [
                            'image' => 'https://via.placeholder.com/32',
                            'user' => 'Pierre Lambert',
                            'rating' => 3,
                            'comment' => 'Matériel correct mais un peu usé. Le trépied avait quelques problèmes de stabilité.',
                            'item' => 'Trépied Manfrotto',
                            'date' => '11 mai 2025'
                        ])
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir tous les avis</a>
                    </div>
                </div>
            </div>

            <!-- Recent users and premium listings -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Nouveaux utilisateurs</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @include('admin.components.user-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'name' => 'Thomas Moreau',
                            'date' => 'Inscrit le 14 mai 2025',
                            'role' => 'Client',
                            'roleColor' => 'green'
                        ])

                        @include('admin.components.user-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'name' => 'Sarah Petit',
                            'date' => 'Inscrit le 13 mai 2025',
                            'role' => 'Partenaire',
                            'roleColor' => 'blue'
                        ])

                        @include('admin.components.user-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'name' => 'Lucie Bernard',
                            'date' => 'Inscrit le 12 mai 2025',
                            'role' => 'Client',
                            'roleColor' => 'green'
                        ])

                        @include('admin.components.user-item', [
                            'image' => 'https://via.placeholder.com/40',
                            'name' => 'Antoine Rousseau',
                            'date' => 'Inscrit le 11 mai 2025',
                            'role' => 'Partenaire',
                            'roleColor' => 'blue'
                        ])
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir tous les utilisateurs</a>
                    </div>
                </div>

                <!-- Premium listings -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Annonces premium</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @include('admin.components.listing-item', [
                            'title' => 'Caméra Canon EOS R5',
                            'status' => 'Active',
                            'location' => 'Paris',
                            'price' => '€60/jour',
                            'date' => 'Jusqu\'au 25 mai 2025',
                            'reservations' => '2 réservations',
                            'status' => 'Pending'
                        ])

                        @include('admin.components.listing-item', [
                            'title' => 'Drone DJI Mavic 3',
                            'status' => 'Active',
                            'location' => 'Lyon',
                            'price' => '€80/jour',
                            'date' => 'Jusqu\'au 30 mai 2025',
                            'reservations' => '5 réservations',
                            'status' => 'Rejected'
                        ])

                        @include('admin.components.listing-item', [
                            'title' => 'Éclairage professionnel',
                            'status' => 'Active',
                            'location' => 'Marseille',
                            'price' => '€45/jour',
                            'date' => 'Jusqu\'au 22 mai 2025',
                            'reservations' => '3 réservations',
                            'status' => 'Pending'
                        ])

                        @include('admin.components.listing-item', [
                            'title' => 'Microphone shotgun',
                            'status' => 'Expiré',
                            'location' => 'Toulouse',
                            'price' => '€25/jour',
                            'date' => 'Expiré le 10 mai 2025',
                            'reservations' => '1 réservation',
                            'status' => 'Expired'
                        ])
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir toutes les annonces premium</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
