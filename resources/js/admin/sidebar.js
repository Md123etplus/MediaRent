document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    let isOpen = false;

    function toggleSidebar() {
        isOpen = !isOpen;

        if (isOpen) {
            // Afficher l'overlay et le sidebar
            overlay.classList.remove('hidden');
            sidebar.classList.remove('hidden');
            setTimeout(() => {
                sidebar.classList.remove('-translate-x-full');
            }, 10);
        } else {
            // Cacher le sidebar puis l'overlay
            sidebar.classList.add('-translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            }, 300);
        }

        // Changer l'icône
        const icon = mobileMenuButton.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
    }

    function closeSidebar() {
        if (isOpen) {
            toggleSidebar();
        }
    }

    // Bouton du menu
    mobileMenuButton.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleSidebar();
    });

    // Clic sur l'overlay pour fermer
    overlay.addEventListener('click', closeSidebar);

    // Fermer quand on clique à l'extérieur
    document.addEventListener('click', function(e) {
        if (isOpen && !sidebar.contains(e.target)) {
            closeSidebar();
        }
    });

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (isOpen && e.key === 'Escape') {
            closeSidebar();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('annonces-menu-button');
    const menu = document.getElementById('annonces-menu');
    const chevron = document.getElementById('annonces-chevron');

    menuButton.addEventListener('click', function(e) {
        e.stopPropagation(); // Empêche la propagation du clic

        // Basculer la visibilité du menu
        menu.classList.toggle('hidden');

        // Faire pivoter la flèche
        if (menu.classList.contains('hidden')) {
            chevron.classList.remove('transform', 'rotate-180');
        } else {
            chevron.classList.add('transform', 'rotate-180');
        }
    });

    // Fermer le menu si on clique ailleurs
    document.addEventListener('click', function() {
        menu.classList.add('hidden');
        chevron.classList.remove('transform', 'rotate-180');
    });

    // Empêcher la fermeture quand on clique dans le menu
    menu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

document.addEventListener('alpine:init', () => {
    Alpine.data('toast', () => ({
        toasts: [],
        addToast(type, message, duration = 3000) {
            const id = Date.now();
            this.toasts.push({ id, type, message });

            if (duration) {
                setTimeout(() => {
                    this.removeToast(id);
                }, duration);
            }
        },
        removeToast(id) {
            this.toasts = this.toasts.filter(toast => toast.id !== id);
        }
    }));
});

// Fonction helper globale pour afficher les toasts
window.showToast = function(type, message, duration = 3000) {
    const toastComponent = document.querySelector('[x-data="toast"]');
    if (toastComponent) {
        Alpine.$data(toastComponent).addToast(type, message, duration);
    } else {
        console.error('Toast component not found');
    }
};
