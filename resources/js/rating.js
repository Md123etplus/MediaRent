// Gestion des étoiles de rating
document.querySelectorAll('.star-rating').forEach(star => {
    star.addEventListener('click', function() {
        const value = this.dataset.value;
        const container = this.parentElement;
        const inputId = container.parentElement.querySelector('input[type="hidden"]').id;
        
        // Met à jour les étoiles
        container.querySelectorAll('svg').forEach((svg, index) => {
            if (index < value) {
                svg.classList.add('text-yellow-400');
                svg.classList.remove('text-gray-300');
            } else {
                svg.classList.remove('text-yellow-400');
                svg.classList.add('text-gray-300');
            }
        });
        
        // Met à jour la valeur cachée
        document.getElementById(inputId).value = value;
    });
});