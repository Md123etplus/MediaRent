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
                    'value' => number_format($stats['total_users'], 0, ',', ' '),
                    'icon' => 'users',
                    'trend' => ($stats['users_growth'] > 0 ? '+' : '').$stats['users_growth'].'%',
                    'trendColor' => $stats['users_growth'] >= 0 ? 'green' : 'red',
                    'description' => 'depuis le mois dernier'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Annonces',
                    'value' => $stats['annonces'],
                    'icon' => 'list-alt',
                    'trend' => ($stats['premium_growth'] > 0 ? '+' : '').$stats['premium_growth'].'%',
                    'trendColor' => $stats['premium_growth'] >= 0 ? 'green' : 'red',
                    'description' => 'dont '.$stats['premium_annonces'].' premium'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Réservations',
                    'value' => number_format($stats['total_reservations'], 0, ',', ' '),
                    'icon' => 'calendar-check',
                    'trend' => $stats['current_month_reservations'],
                    'trendColor' => 'blue',
                    'description' => 'ce mois-ci'
                ])

                @include('admin.components.stats-card', [
                    'title' => 'Revenus',
                    'value' => '€'.number_format($stats['revenue_month'], 0, ',', ' '),
                    'icon' => 'euro-sign',
                    'trend' => '€'.number_format($stats['revenue_week'], 0, ',', ' '),
                    'trendColor' => 'green',
                    'description' => 'cette semaine'
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
                        @foreach($latestReservations as $reservation)
                            @include('admin.components.reservation-item', [
                                'image' => $reservation->annonce->objet->images->first()->url ?? 'https://via.placeholder.com/40',
                                'item' => $reservation->annonce->objet->nom,
                                'user' => $reservation->client->prenom.' '.$reservation->client->nom,
                                'price' => '€'.$reservation->annonce->objet->prix_journalier.'/jour',
                                'dates' => Carbon\Carbon::parse($reservation->date_debut)->format('d-m-Y').' - '.Carbon\Carbon::parse($reservation->date_fin)->format('d-m-Y'),
                                'status' => $reservation->statut
                            ])
                        @endforeach
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="{{ route('admin.reservations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir toutes les réservations</a>
                    </div>
                </div>

                <!-- Recent reviews -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Avis récents</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($recentReviews as $review)
                            @include('admin.components.review-item', [
                                'id' => $review->id,
                                'image' => $review->evaluateur->img_profil ?? 'https://via.placeholder.com/32',
                                'user' => $review->evaluateur->prenom.' '.$review->evaluateur->nom,
                                'rating' => $review->note_objet,
                                'comment' => $review->commentaire_objet,
                                'item' => $review->objet->nom,
                                'date' => Carbon\Carbon::parse($review->date)->format('d F Y'),
                                'is_visible' => $review->is_visible
                            ])
                        @endforeach
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="{{ route('admin.evaluations.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir tous les avis</a>
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
                        @foreach($newUsers as $user)
                            @include('admin.components.user-item', [
                                'image' => $user->img_profil ?? 'https://via.placeholder.com/40',
                                'name' => $user->prenom.' '.$user->nom,
                                'email' => $user->email,
                                'date' => $user->created_at->format('d/m/Y'),
                                'role' => $user->role == 'partenaire' ? 'Partenaire' : 'Client',
                                'roleColor' => $user->role == 'partenaire' ? 'blue' : 'green',
                                'reservations' => $user->total_reservations,
                                'status' => $user->status ?? 'active',
                                'isSuspended' => $user->is_suspended,
                                'id' => $user->id
                            ])
                        @endforeach
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir tous les utilisateurs</a>
                    </div>
                </div>

                <!-- Premium listings -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Annonces premium</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($premiumAnnonces as $annonce)
                            @php
                                $reservationCount = $annonce->reservations->count();
                                $status = $annonce->statut;
                                $statusColor = $status === 'active' ? 'green' : ($status === 'pending' ? 'orange' : 'red');
                            @endphp

                            @include('admin.components.listing-item', [
                                'id' => $annonce->id,
                                'title' => $annonce->objet->nom,
                                'status' => ucfirst($annonce->statut),
                                'statusColor' => $statusColor,
                                'location' => $annonce->objet->ville,
                                'price' => '€'.$annonce->objet->prix_journalier.'/jour',
                                'date' => 'Jusqu\'au '.Carbon\Carbon::parse($annonce->date_fin)->format('d F Y'),
                                'reservations' => $reservationCount.' réservation'.($reservationCount > 1 ? 's' : ''),
                                'image' => $annonce->objet->images->first()->url ?? 'https://via.placeholder.com/40'
                            ])
                        @endforeach
                    </div>
                    <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-right">
                        <a href="{{ route('admin.annonces.index', 'premium') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Voir toutes les annonces premium</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
