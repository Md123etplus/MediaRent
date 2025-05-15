@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* Base Styles */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
}

/* Sidebar Styles */
.sidebar {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    z-index: 10;
}

.glass-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.18);
}

.nav-item {
    @apply flex items-center space-x-3 px-4 py-3 text-gray-600 font-medium rounded-lg mx-2 transition-all duration-200;
}

.nav-item:hover {
    @apply bg-indigo-50 text-indigo-600;
}

.nav-item i {
    @apply w-5 text-center;
}

.nav-item.active {
    @apply bg-indigo-100 text-indigo-700 font-semibold;
}

/* Statistics Cards */
.stat-card {
    @apply p-5 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md;
}

.stat-icon {
    @apply p-3 bg-white rounded-lg shadow-sm;
}

/* Archive Items */
.archive-item {
    @apply flex justify-between items-center p-4 mb-3 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-200;
}

.archive-icon {
    @apply p-3 bg-red-50 rounded-lg text-red-500;
}

/* Buttons */
.btn-primary {
    @apply bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200;
}

.btn-primary:hover {
    @apply shadow-md;
}

/* Animations */
.float-animation {
    animation: float 6s ease-in-out infinite;
}

.fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

.delay-100 {
    animation-delay: 0.1s;
}

.delay-200 {
    animation-delay: 0.2s;
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0px); }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Style minimaliste pour le calendrier */
#calendar {
  height: 500px; /* Hauteur réduite */
  font-family: 'Poppins', sans-serif;
}

/* En-tête */
.fc-header-toolbar {
  @apply mb-3 flex flex-col sm:flex-row items-start sm:items-center gap-2;
}

.fc-toolbar-title {
  @apply text-lg font-medium text-gray-700;
}

/* Boutons */
.fc-button {
  @apply bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-3 py-1 text-sm;
  border-radius: 6px !important;
}

.fc-button-primary {
  @apply bg-amber-500 border-amber-500 text-white hover:bg-amber-600;
}

/* Cellules */
.fc-daygrid-day-frame {
  @apply hover:bg-gray-50;
}

.fc-day-today {
  @apply bg-amber-50 !important;
}

.fc-col-header-cell {
  @apply bg-gray-50 py-2 text-gray-600 text-sm;
}

/* Événements - Style inspiré des archives */
.fc-event {
  @apply rounded-lg border-0 shadow-xs px-2 py-1 text-xs m-0.5;
  background-color: #f5f5f5;
  border-left: 3px solid #eab308; /* Jaune/ambre */
}

.fc-event-main {
  @apply flex items-center;
}

.fc-event-title {
  @apply truncate;
}

/* Style spécifique pour les réservations */
.fc-event[title*="Réservation"] {
  border-left-color: #84cc16; /* Vert */
  background-color: #f0fdf4;
}

/* Style pour maintenance */
.fc-event[title*="Maintenance"] {
  border-left-color: #ef4444; /* Rouge */
  background-color: #fef2f2;
}

/* Responsive */
@media (max-width: 768px) {
  #calendar {
    height: 200px;
  }
  
  .fc-toolbar-title {
    font-size: 1rem;
  }
  
  .fc-button {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }
}
/* Responsive Adjustments */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        position: fixed;
        height: 100vh;
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
}

/* Modal Styling */
#availability-modal .glass-card {
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form Elements */
input, select {
    @apply transition-all duration-200;
}

input:focus, select:focus {
    @apply ring-2 ring-indigo-200 border-indigo-300;
}
</style>
@endsection

@section('content')
<div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
  <!-- Sidebar -->
  <div class="w-64 sidebar">
    <div class="p-4 flex items-center space-x-4 glass-card">
         <div>
        <h2 class="text-lg font-bold text-gray-800">{{ Auth::user()?->prenom ?? 'Test Guest' }}</h2>
        <p class="text-xs text-indigo-500 font-medium">Partenaire MediaRent</p>
      </div>
    </div>

    <nav class="mt-6">
      <div class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
        Gestion
      </div>
      <a href="{{ route('annonces.create') }}" class="nav-item">
        <i class="fas fa-plus-circle"></i>
        <span>Ajouter une annonce</span>
      </a>
      <a href="{{ route('partenaire.objets.create') }}" class="nav-item">
        <i class="fas fa-cube"></i>
        <span>Ajouter un objet</span>
      </a>
      <a href="{{ route('annonces.mes_annonces') }}" class="nav-item">
        <i class="fas fa-list"></i>
        <span>Mes annonces</span>
      </a>
      <a href="{{ route('objet.mes_objets') }}" class="nav-item">
        <i class="fas fa-boxes"></i>
        <span>Mes objets</span>
      </a>
      <a href="{{ route('annonces.index') }}" class="nav-item">
        <i class="fas fa-boxes"></i>
        <span>Option Premium</span>
      </a>

      <div class="mt-10 px-2">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="nav-item w-full text-red-600 hover:text-red-700">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
          </button>
        </form>
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="flex-1 overflow-x-hidden">
    <main class="container mx-auto px-4 py-8">
      <!-- Statistics Section -->
      <section class="mb-10">
  <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
    <i class="fas fa-chart-line text-indigo-500 mr-3"></i>
    Statistiques
  </h2>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Revenue Card -->
    <div class="bg-gradient-to-br from-green-50 to-green-100 p-5 rounded-lg shadow hover:shadow-md transition-shadow">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm font-medium text-gray-600">Revenu Total</p>
          <p class="text-3xl font-bold text-green-700 mt-1">{{ number_format($revenuTotal, 2) }} DH</p>
        </div>
        <div class="p-3 bg-white rounded-lg shadow-sm text-green-600">
          <i class="fas fa-coins text-lg"></i>
        </div>
      </div>
      <div class="mt-4 flex justify-between items-center">
        <span class="text-sm text-green-600 font-medium">+{{ $nombreReservations }} locations</span>
        <a href="{{ route('partenaire.reservations') }}" class="text-xs text-green-700 hover:underline flex items-center">
          Voir détails <i class="fas fa-chevron-right ml-1 text-xs"></i>
        </a>
      </div>
    </div>

    <!-- Active Listings Card -->
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-lg shadow hover:shadow-md transition-shadow">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm font-medium text-gray-600">Annonces Actives</p>
          <p class="text-3xl font-bold text-blue-700 mt-1">{{ $annoncesActives }}</p>
        </div>
        <div class="p-3 bg-white rounded-lg shadow-sm text-blue-600">
          <i class="fas fa-bullhorn text-lg"></i>
        </div>
      </div>
      <div class="mt-4">
        <div class="w-full bg-blue-200 rounded-full h-2">
          <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalAnnonces ? round(($annoncesActives / $totalAnnonces) * 100, 2) : 0 }}%%"></div>
        </div>
        <p class="text-xs text-blue-600 mt-1 text-right">{{ $annoncesActives . '/' . $totalAnnonces . ($totalAnnonces > 0 ? ' (' . round(($annoncesActives / $totalAnnonces) * 100, 2) . '%)' : '') }} annonces</p>
      </div>
    </div>

    <!-- Occupancy Rate Card -->
    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-lg shadow hover:shadow-md transition-shadow">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm font-medium text-gray-600">Taux d'occupation</p>
          <p class="text-3xl font-bold text-purple-700 mt-1">{{ $tauxOccupation }}%</p>
        </div>
        <div class="p-3 bg-white rounded-lg shadow-sm text-purple-600">
          <i class="fas fa-chart-line text-lg"></i>
        </div>
      </div>
      <div class="mt-4">
        <div class="w-full bg-purple-200 rounded-full h-2">
          <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $tauxOccupation }}%"></div>
        </div>
        <p class="text-xs text-purple-600 mt-1 text-right">{{ $joursOccupes }}/{{ $joursDisponibles }} jours</p>
      </div>
    </div>
  </div>
</section>

      <section class="fade-in delay-100">
  <div class="glass-card rounded-2xl shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
      <h2 class="text-xl font-bold text-gray-800 flex items-center">
        <i class="fas fa-archive text-red-500 mr-3 text-xl"></i>
        <span>Archives des annonces</span>
      </h2>
      <div class="flex space-x-3">
        <button id="refresh-archives" class="btn-primary flex items-center space-x-2 px-4 py-2 text-sm rounded-lg">
          <i class="fas fa-sync-alt"></i>
          <span>Rafraîchir</span>
        </button>
      </div>
    </div>
    
    <div class="p-6 bg-gray-50">
      @forelse($annoncesArchives as $annonce)
      <div class="archive-item mb-4">
        <div class="archive-card bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md">
          <div class="p-5 flex flex-col md:flex-row md:items-center justify-between">
            <div class="flex items-start space-x-4">
              <div class="flex-shrink-0">
                <div class="archive-icon bg-red-100 p-3 rounded-lg text-red-500">
                  <i class="fas fa-box-open text-xl"></i>
                </div>
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $annonce->objet->nom }}</h3>
                <div class="mt-2 flex flex-wrap gap-3 text-sm">
                  <span class="flex items-center text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    <i class="far fa-calendar-alt mr-1 text-red-400"></i>
                    {{ $annonce->date_publication->format('d/m/Y') }}
                  </span>
                  <span class="flex items-center text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    <i class="fas fa-tag mr-1 text-blue-400"></i>
                    {{ $annonce->objet->categorie->nom ?? 'Non catégorisé' }}
                  </span>
                  <span class="flex items-center text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    <i class="fas fa-money-bill-wave mr-1 text-green-400"></i>
                    {{ $annonce->objet->prix_journalier }} DH/jour
                  </span>
                </div>
              </div>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-2">
              <form method="POST" action="{{ route('partenaire.annonce.restore', $annonce->id) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                  <i class="fas fa-undo"></i>
                  <span>Restaurer</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="text-center py-12">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
          <i class="fas fa-box-open text-gray-300 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-700">Aucune annonce archivée</h3>
        <p class="text-gray-500 mt-2 max-w-md mx-auto">
          Vos annonces archivées apparaîtront ici. Les archives conservent vos annonces pendant 6 mois.
        </p>
      </div>
      @endforelse
    </div>
  </div>
</section>

      <!-- Availability Management -->
      <section class="mt-8 fade-in delay-200">
  <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
      <h2 class="text-xl font-bold text-gray-800 flex items-center mb-4 md:mb-0">
        <i class="fas fa-calendar-alt text-indigo-500 mr-3 text-xl"></i>
        Gestion des disponibilités
      </h2>
      <div class="flex space-x-2 w-full md:w-auto">
        <button id="add-availability" class="btn-primary flex items-center space-x-2 px-4 py-2 text-sm rounded-lg">
          <i class="fas fa-plus"></i>
          <span>Ajouter disponibilité</span>
        </button>
      </div>
    </div>
    <div id="calendar"></div>
  </div>
</section>
    </main>
  </div>

  <!-- Add Availability Modal -->
  <div id="availability-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl p-6 w-full max-w-md glass-card">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold text-gray-800">Ajouter une disponibilité</h3>
        <button id="close-modal" class="text-gray-500 hover:text-gray-700">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <form id="availability-form">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-medium mb-2">Objet</label>
          <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @foreach($objets as $objet)
            <option value="{{ $objet->id }}">{{ $objet->nom }}</option>
            @endforeach
          </select>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Date début</label>
            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
          <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Date fin</label>
            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
          </div>
        </div>
        <div class="flex justify-end space-x-3">
          <button type="button" id="cancel-availability" class="px-4 py-2 text-gray-600 hover:text-gray-800">
            Annuler
          </button>
          <button type="submit" class="btn-primary px-4 py-2">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        views: {
            dayGridMonth: {
                dayMaxEventRows: 3, // Limite le nombre d'événements visibles
            },
            timeGridWeek: {
                dayMaxEventRows: 4,
            }
        },
        events: [
            @foreach($reservations as $reservation)
            {
                title: '📌 {{ $reservation->annonce->objet->nom }}',
                start: '{{ $reservation->date_debut }}',
                end: '{{ \Carbon\Carbon::parse($reservation->date_fin)->addDay()->format('Y-m-d') }}',
                color: '#6366f1',
                extendedProps: {
                    client: '{{ $reservation->client->prenom }} {{ $reservation->client->nom }}',
                    status: '{{ $reservation->statut }}',
                    price: '{{ $reservation->annonce->objet->prix_journalier }} DH/jour'
                }
            },
            @endforeach
            {
                title: '🔧 Maintenance',
                start: '2025-05-15',
                end: '2025-05-17',
                color: '#f59e0b',
                extendedProps: {
                    type: 'maintenance'
                }
            }
        ],
        eventClick: function(info) {
            const event = info.event;
            let content = `
                <div class="p-3">
                    <h4 class="font-bold text-lg mb-2">${event.title}</h4>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="far fa-calendar-alt mr-2 text-indigo-500"></i>
                            ${event.start.toLocaleDateString()} - ${event.end.toLocaleDateString()}
                        </p>
            `;

            if (event.extendedProps.client) {
                content += `
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-user mr-2 text-indigo-500"></i>
                            <span class="font-medium">Client:</span> ${event.extendedProps.client}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-tag mr-2 text-indigo-500"></i>
                            <span class="font-medium">Statut:</span> ${event.extendedProps.status}
                        </p>
                        <p class="text-sm text-gray-600 flex items-center">
                            <i class="fas fa-money-bill-wave mr-2 text-indigo-500"></i>
                            <span class="font-medium">Prix:</span> ${event.extendedProps.price}
                        </p>
                `;
            }

            content += `
                    </div>
                </div>
            `;

            const popover = new bootstrap.Popover(info.el, {
                container: 'body',
                placement: 'auto',
                title: 'Détails de la réservation',
                content: content,
                html: true,
                trigger: 'click',
                customClass: 'custom-popover'
            });
            
            popover.show();
            
            // Fermer les autres popovers
            document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
                if (el !== info.el) {
                    bootstrap.Popover.getInstance(el)?.hide();
                }
            });
        },
        eventDidMount: function(info) {
            // Style des événements
            if (info.event.extendedProps.type === 'maintenance') {
                info.el.style.borderLeft = '3px solid #f59e0b';
                info.el.style.backgroundColor = 'rgba(245, 158, 11, 0.1)';
            } else {
                info.el.style.borderLeft = '3px solid #6366f1';
                info.el.style.backgroundColor = 'rgba(99, 102, 241, 0.1)';
            }
            
            // Ajouter un effet de survol
            info.el.addEventListener('mouseenter', () => {
                info.el.style.transform = 'translateY(-1px)';
                info.el.style.boxShadow = '0 2px 5px rgba(0,0,0,0.1)';
            });
            info.el.addEventListener('mouseleave', () => {
                info.el.style.transform = '';
                info.el.style.boxShadow = '';
            });
        },
        dateClick: function(info) {
            console.log('Clicked on: ' + info.dateStr);
        }
    });

    calendar.render();
    // Modal Handling
    const modal = document.getElementById('availability-modal');
    const openModalBtn = document.getElementById('add-availability');
    const closeModalBtn = document.getElementById('close-modal');
    const cancelBtn = document.getElementById('cancel-availability');

    if (openModalBtn) {
        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    }

    // Form Submission
    const form = document.getElementById('availability-form');
    if (form) {
        // Dans votre script de soumission du formulaire
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                objet_id: form.querySelector('[name="objet_id"]').value,
                date_debut: form.querySelector('[name="date_debut"]').value,
                date_fin: form.querySelector('[name="date_fin"]').value
            })
        });

        const data = await response.json();

        if (response.ok) {
            // Ajoutez la nouvelle disponibilité au calendrier
            calendar.addEvent({
                title: 'Disponible: ' + data.objet_nom,
                start: data.date_debut,
                end: data.date_fin,
                color: '#10B981', // Couleur verte
                allDay: true
            });
            
            // Fermez le modal
            modal.classList.add('hidden');
            
            // Affichez un message de succès
            alert('Disponibilité ajoutée avec succès!');
        } else {
            throw new Error(data.message || 'Erreur lors de l\'ajout');
        }
    } catch (error) {
        console.error('Error:', error);
        alert("Erreur: " + error.message);
    }
});
    }

    // Refresh archives button
    document.getElementById('refresh-archives')?.addEventListener('click', function() {
        const btn = this;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...';
        btn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            window.location.reload();
        }, 1000);
    });
});
</script>
@endsection