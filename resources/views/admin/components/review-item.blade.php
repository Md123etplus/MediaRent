<div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700" id="review-{{ $id }}">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <img class="w-8 h-8 rounded-full" src="{{ $image }}" alt="{{ $user }}">
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $user }}</p>
                <span class="visibility-badge px-2 py-1 text-xs rounded-full {{ $is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $is_visible ? 'Visible' : 'Masqué' }}
                </span>
            </div>
        </div>
        <div class="flex">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $rating)
                    <i class="fas fa-star text-yellow-400"></i>
                @else
                    <i class="far fa-star text-yellow-400"></i>
                @endif
            @endfor
        </div>
    </div>
    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">"{{ $comment }}"</p>
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Sur {{ $item }} - {{ $date }}</p>

    @if(isset($actions) && $actions)
    <div class="mt-3 flex justify-end space-x-2">
        <button id="toggle-btn-{{ $evaluation->id }}"
                onclick="toggleVisibility({{ $evaluation->id }})"
                class="px-3 py-1 rounded text-sm {{ $evaluation->is_visible ? 'bg-red-100 text-red-800 hover:bg-red-200' : 'bg-green-100 text-green-800 hover:bg-green-200' }}">
            <i class="fas {{ $evaluation->is_visible ? 'fa-eye-slash' : 'fa-eye' }}"></i>
            {{ $evaluation->is_visible ? 'Masquer' : 'Afficher' }}
        </button>
        <button class="px-3 py-1 text-xs bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900 dark:text-green-200 dark:hover:bg-green-800 rounded" title="Approuver">
            <i class="fas fa-check mr-1"></i> Approuver
        </button>
        <button class="px-3 py-1 text-xs bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 rounded" title="Rejeter">
            <i class="fas fa-times mr-1"></i> Rejeter
        </button>
    </div>
    @endif
</div>

@push('scripts')
<script>
    // Fonction pour basculer la visibilité
    function toggleVisibility(reviewId) {
        // Récupérer le bouton pour changer son état pendant le chargement
        const button = document.querySelector(`#toggle-btn-${reviewId}`);
        const originalText = button.innerHTML;

        // Confirmation avant de procéder
        if (!confirm('Voulez-vous vraiment changer la visibilité de cette évaluation ?')) {
            return;
        }

        // Afficher un indicateur de chargement
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;

        fetch(`/admin/evaluations/${reviewId}/toggle-visibility`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Mettre à jour le badge de statut
                const badge = document.querySelector(`#review-${reviewId} .visibility-badge`);
                if (badge) {
                    badge.textContent = data.is_visible ? 'Visible' : 'Masqué';
                    badge.className = `px-2 py-1 text-xs rounded-full ${
                        data.is_visible ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                    }`;
                }

                // Mettre à jour le bouton
                button.innerHTML = data.is_visible
                    ? '<i class="fas fa-eye-slash"></i> Masquer'
                    : '<i class="fas fa-eye"></i> Afficher';
                button.className = `px-3 py-1 rounded text-sm ${
                    data.is_visible
                        ? 'bg-red-100 text-red-800 hover:bg-red-200'
                        : 'bg-green-100 text-green-800 hover:bg-green-200'
                }`;

                // Optionnel: Afficher une notification toast
                alert(data.message);
                showToast('success', data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            button.innerHTML = originalText;
            showToast('error', 'Une erreur est survenue');
        })
        .finally(() => {
            button.disabled = false;
        });
    }

    // Fonction helper pour les notifications (à ajouter si vous n'en avez pas)
    function showToast(type, message) {
        // Implémentation basique - à adapter à votre système de notifications
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>
@endpush
