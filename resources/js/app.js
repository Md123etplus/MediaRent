import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'

Alpine.plugin(persist)
Alpine.start()

// import './bootstrap';
    document.addEventListener('alpine:init', () => {
        Alpine.data('header', () => ({
            darkMode: localStorage.getItem('darkMode') === 'true' || 
                     (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
            mobileMenuOpen: false,
            mobileSearchOpen: false,
            
            init() {
                // Apply dark mode on initial load
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                }
                
                // Smooth scroll for all anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', this.smoothScroll);
                });
            },
            
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('darkMode', this.darkMode);
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            },
            
            smoothScroll(e) {
                e.preventDefault();
                const targetId = e.currentTarget.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Update URL without jumping
                    history.pushState(null, null, targetId);
                }
            }
        }));
    });
    
