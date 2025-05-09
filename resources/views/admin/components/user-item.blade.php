<div class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700" id="user-row-{{ $id }}">
    <div class="flex-shrink-0">
        <img class="w-10 h-10 rounded-full" src="{{ $image }}" alt="{{ $name }}">
    </div>
    <div class="ml-4 flex-1 min-w-0">
        <div class="flex justify-between">
            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                {{ $name }}
                <span class="ml-2 text-xs px-2 py-0.5 rounded-full bg-{{ $roleColor }}-100 text-{{ $roleColor }}-800">{{ $role }}</span>
                <span id="user-status-{{ $id }}" class="ml-2 px-2 py-0.5 rounded-full {{ $isSuspended ? 'bg-red-100 text-red-800' : 'hidden' }}">Suspendu</span>
            </p>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $reservations }} réservations
            </div>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $email }}</p>
        <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
            <span>{{ $date }}</span>
        </div>
    </div>
    <div class="ml-4">
        <button
            id="suspend-btn-{{ $id }}"
            onclick="toggleUserSuspension({{ $id }})"
            class="px-3 py-1 text-xs rounded-md {{ $isSuspended ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}"
        >
            {{ $isSuspended ? 'Activer' : 'Suspendre' }}
        </button>
    </div>
</div>

@push('scripts')
<script>
async function toggleUserSuspension(userId) {
    const button = document.querySelector(`#suspend-btn-${userId}`);
    const originalText = button.innerHTML;

    try {
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;

        const response = await fetch(`/admin/users/${userId}/toggle-suspension`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (!response.ok) throw new Error(data.message || 'Erreur serveur');

        // Mise à jour du badge de statut
        const statusBadge = document.querySelector(`#user-status-${userId}`);
        if (statusBadge) {
            statusBadge.classList.toggle('hidden', !data.is_suspended);
            statusBadge.classList.toggle('bg-red-100', data.is_suspended);
            statusBadge.classList.toggle('text-red-800', data.is_suspended);
        }

        // Mise à jour du bouton
        button.innerHTML = data.is_suspended ? 'Activer' : 'Suspendre';
        button.classList.toggle('bg-green-600', data.is_suspended);
        button.classList.toggle('hover:bg-green-700', data.is_suspended);
        button.classList.toggle('bg-red-600', !data.is_suspended);
        button.classList.toggle('hover:bg-red-700', !data.is_suspended);

        // Notification
        showToast('success', data.message);

    } catch (error) {
        console.error('Error:', error);
        showToast('error', error.message || 'Erreur lors de la modification');
        button.innerHTML = originalText;
    } finally {
        button.disabled = false;
    }
}
</script>
@endpush
