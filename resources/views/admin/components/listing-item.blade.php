<div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $title }}</p>
                <span data-annonce-status="{{ $id }}" class="px-2 py-1 text-xs font-medium rounded-full
                    @if($status === 'Active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($status === 'Archivée') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                    @elseif($status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                    @endif">
                    {{ ucfirst($status) }}
                </span>
            </div>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                <span class="font-medium">{{ $location }}</span> - {{ $price }}
            </p>

            <div class="mt-2 flex flex-wrap items-center text-sm text-gray-500 dark:text-gray-400">
                <span>{{ $date }}</span>
                <span class="mx-2 hidden sm:inline">•</span>
                <span class="mt-1 sm:mt-0">{{ $reservations }}</span>

                @if(isset($premium) && $premium)
                <span class="ml-2 px-1.5 py-0.5 text-xs rounded bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                    <i class="fas fa-crown mr-1"></i> Premium
                </span>
                @endif
            </div>
        </div>

        <div class="ml-4 flex-shrink-0">
            <img class="h-12 w-12 rounded-md object-cover" src="{{ $thumbnail ?? 'https://via.placeholder.com/48' }}" alt="{{ $title }}">
        </div>
    </div>

    @if(isset($actions) && $actions)
    <div class="mt-3 flex justify-end space-x-2">
        <button onclick="showAnnonceDetails({{ $id }})"
                class="px-3 py-1 text-xs bg-blue-100 text-blue-800 hover:bg-blue-200 rounded">
            <i class="fas fa-eye mr-1"></i> Voir
        </button>
        {{-- <button class="px-3 py-1 text-xs bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded" title="Approuver">
            <i class="fas fa-check mr-1"></i> Approuver
        </button>
        <button class="px-3 py-1 text-xs bg-yellow-100 text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-900 dark:text-yellow-200 dark:hover:bg-yellow-800 rounded" title="Modifier">
            <i class="fas fa-edit mr-1"></i> Modifier
        </button> --}}
        <button onclick="toggleArchiveAnnonce({{ $id }}, '{{ $status }}')"
                class="px-3 py-1 text-xs rounded {{ $status === 'Archivée' ? 'text-green-100 bg-green-800' : 'text-red-100 bg-red-800' }} dark:{{ $status === 'Archivée' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200' }}"
                title="{{ $status === 'Archivée' ? 'Réactiver' : 'Archiver' }}"
                id="archive-btn-{{ $id }}">
            <i class="fas {{ $status === 'Archivée' ? 'fa-undo' : 'fa-trash' }} mr-1"></i>
            {{ $status === 'Archivée' ? 'Réactiver' : 'Archiver' }}
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script>
// Fonction pour afficher les détails
async function showAnnonceDetails(annonceId) {
    try {
        // Afficher le modal
        const modal = document.getElementById('annonce-modal');
        modal.classList.remove('hidden');

        // Charger les données
        const response = await fetch(`/admin/annonces/${annonceId}/details`);
        const data = await response.json();

        if (data.success) {
            document.getElementById('annonce-modal-content').innerHTML = data.html;
        }
    } catch (error) {
        console.error('Erreur:', error);
        alert('Impossible de charger les détails');
    }
}

// Fonction pour fermer le modal
function closeAnnonceModal() {
    document.getElementById('annonce-modal').classList.add('hidden');
}

// Fermer quand on clique en dehors du modal
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('annonce-modal');
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeAnnonceModal();
        }
    });
});

//toggle annonce
async function toggleArchiveAnnonce(annonceId, currentStatus) {

    if (!confirm(currentStatus === 'Archivée'
        ? 'Voulez-vous vraiment réactiver cette annonce ?'
        : 'Voulez-vous vraiment archiver cette annonce ?')) {
        return;
    }

    const btn = document.getElementById(`archive-btn-${annonceId}`);
    const originalText = btn.innerHTML;

    try {
        // Afficher un indicateur de chargement
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Traitement...';
        btn.disabled = true;

        const response = await fetch(`/admin/annonces/${annonceId}/toggle-archive`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            alert(data.message);
            // Mise à jour de l'interface
            btn.innerHTML = `<i class="fas ${data.new_status === 'Archivée' ? 'fa-undo' : 'fa-trash'} mr-1"></i> ${data.new_button_text}`;
            btn.className = `px-3 py-1 text-xs rounded ${data.new_button_class} dark:${data.new_status === 'Archivée' ? 'bg-green-900 text-green-200' : 'bg-red-900 text-red-200'}`;
            btn.title = data.new_button_text;

            // Mise à jour du statut affiché
            const statusElement = document.querySelector(`[data-annonce-status="${annonceId}"]`);
            if (statusElement) {
                statusElement.textContent = data.new_status_label;
                statusElement.className = `px-2 py-1 text-xs font-medium rounded-full ${
                    data.new_status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                    data.new_status === 'Archivée' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' :
                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
                }`;
            }

            showToast('success', data.message);
        } else {
            showToast('error', data.message);
            btn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('error', 'Une erreur est survenue');
        btn.innerHTML = originalText;
    } finally {
        btn.disabled = false;
    }
}
</script>
@endpush
