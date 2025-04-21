import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Initialize Alpine early
window.Alpine = Alpine;
Alpine.plugin(persist);

// Register the header component
Alpine.data('header', () => ({
    darkMode: Alpine.$persist(false).as('darkMode'),
    mobileMenuOpen: Alpine.$persist(false).as('mobileMenuOpen'),
    mobileSearchOpen: false,

    init() {
        // Apply dark mode on initial load
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', this.smoothScroll);
        });
    },

    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        document.documentElement.classList.toggle('dark', this.darkMode);
    },

    smoothScroll(e) {
        e.preventDefault();
        const targetId = e.currentTarget.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            history.pushState(null, null, targetId);
        }
    }
}));

// Start Alpine
Alpine.start();