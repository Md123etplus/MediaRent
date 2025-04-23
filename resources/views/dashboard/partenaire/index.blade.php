@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 sidebar"> 
    <div class="p-4 flex items-center space-x-4 border-b border-gray-200">
        
            <img src="{{ asset('storage/' . Auth::user()->img_profil) }}" 
                 alt="Photo de profil"
                 class="w-12 h-12 rounded-full border-2 border-indigo-100 shadow-md object-cover">
            <div>
                <h2 class="text-lg font-bold text-gray-800">{{ Auth::user()->prenom }}</h2>
                <p class="text-xs text-indigo-600">Partenaire MediaRent</p>
            </div>
        </div>

        <nav class="mt-6">
            <div class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Gestion
            </div>
            <a href="{{ route('annonces.create') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                <i class="fas fa-plus-circle mr-3 text-indigo-400"></i>
                Ajouter une annonce
            </a>
            <a href="{{ route('partenaire.objets.create') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                <i class="fas fa-cube mr-3 text-indigo-400"></i>
                Ajouter un objet
            </a>
            <a href="{{ route('partenaire.annonces.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                <i class="fas fa-list mr-3 text-indigo-400"></i>
                Mes annonces
            </a>
            <a href="{{ route('partenaire.objets.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                <i class="fas fa-boxes mr-3 text-indigo-400"></i>
                Mes objets
            </a>

            <div class="mt-10 px-4 py-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Déconnexion
                    </button>

                </form>
            </div>
        </nav>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1">
        <main class="container mx-auto px-4 py-6">
            <!-- Section Statistiques -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Statistiques</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Carte Revenu Total -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl shadow-lg border border-green-200 transition-transform hover:scale-[1.02]">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 text-sm font-semibold">Revenu Total</h3>
                                <p class="text-3xl font-bold text-green-700 mt-1">{{ number_format($revenuTotal, 2) }} DH</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-coins text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-green-600 font-medium">+{{ $nombreReservations }} locations</span>
                            <a href="{{ route('partenaire.reservations') }}" class="text-xs text-green-700 hover:underline">Voir détails</a>
                        </div>
                    </div>

                    <!-- Carte Annonces Actives -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl shadow-lg border border-blue-200 transition-transform hover:scale-[1.02]">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 text-sm font-semibold">Annonces Actives</h3>
                                <p class="text-3xl font-bold text-blue-700 mt-1">{{ $annoncesActives }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-bullhorn text-blue-600 text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Taux d'occupation -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl shadow-lg border border-purple-200 transition-transform hover:scale-[1.02]">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-gray-600 text-sm font-semibold">Taux d'occupation</h3>
                                <p class="text-3xl font-bold text-purple-700 mt-1">{{ $tauxOccupation }}%</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="fas fa-chart-line text-purple-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="w-full bg-purple-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $tauxOccupation }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Archives -->
            <section>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-bold text-gray-800">Archives des annonces</h2>
                            <div class="flex space-x-3">
                                <button id="refresh-archives" class="flex items-center space-x-1 text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1 rounded-lg">
                                    <i class="fas fa-sync-alt text-sm"></i>
                                    <span class="text-sm">Rafraîchir</span>
                                </button>
                                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-800 bg-gray-50 px-3 py-1 rounded-lg">
                                    <i class="fas fa-filter text-sm"></i>
                                    <span class="text-sm">Filtrer</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @forelse($annoncesArchives as $annonce)
                        <div class="flex items-center justify-between p-4 mb-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-all duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="bg-red-100 p-3 rounded-full">
                                    <i class="fas fa-archive text-red-500"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $annonce->objet->nom }}</h3>
                                    <div class="flex space-x-4 text-sm text-gray-500">
                                        <span><i class="far fa-calendar-alt mr-1"></i> {{ $annonce->date_publication->format('d/m/Y') }}</span>
                                        <span><i class="fas fa-tag mr-1"></i> {{ $annonce->objet->categorie->nom ?? 'Non catégorisé' }}</span>
                                        <span><i class="fas fa-money-bill-wave mr-1"></i> {{ $annonce->objet->prix_journalier }} DH/jour</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('partenaire.annonce.restore', $annonce->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="flex items-center space-x-1 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-sm transition-colors duration-200">
                                        <i class="fas fa-undo text-xs"></i>
                                        <span>Restaurer</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-box-open text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700">Aucune annonce archivée</h3>
                            <p class="text-gray-500 mt-1">Vos annonces archivées apparaîtront ici</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- Section Gestion des disponibilités -->
            <section class="mt-12">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Gestion des disponibilités</h2>
                    <div id="calendar" style="height:500px;"></div>
                </div>
            </section>
        </main>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<style>
    /* Styles essentiels */
    #calendar {
        height: 600px !important;
        width: 100%;
        margin: 20px 0;
        font-family: inherit;
    }
    
    /* Améliorations visuelles */
    .fc-header-toolbar {
        padding: 1rem;
        margin-bottom: 0;
    }
    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
    }
    .fc-button {
        background-color: #4f46e5 !important;
        border: none !important;
        padding: 0.5rem 1rem !important;
    }
    .fc-event {
        cursor: pointer;
        border: none !important;
        padding: 2px 5px !important;
        margin: 2px !important;
    }
    .fc-daygrid-event {
        white-space: normal !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérification élément
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) {
        console.error("ERREUR: Élément #calendar introuvable");
        return;
    }

    // Initialisation
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: [{
            title: 'TEST TECHNIQUE',
            start: new Date().toISOString().split('T')[0],
            end: new Date(Date.now() + 86400000).toISOString().split('T')[0],
            color: '#00FF00',
            extendedProps: {
                debug: true
            }
        }],
        eventDidMount: function(info) {
            console.log("Événement rendu:", info.event.title);
        }
    });

    calendar.render();
    console.log("Calendrier initialisé avec succès");
});
</script>
@endsection