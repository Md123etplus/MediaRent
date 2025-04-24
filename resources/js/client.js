document.addEventListener('DOMContentLoaded', function() {
    // Toggle dark mode
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
            } else {
                html.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            }
        });
    }
    
    // Mark notification as read
    document.querySelectorAll('.mark-as-read').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const notificationId = this.dataset.notificationId;
            const url = this.href;
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const notificationItem = this.closest('.notification-item');
                    notificationItem.classList.remove('bg-blue-50', 'dark:bg-blue-900');
                    notificationItem.classList.add('bg-gray-50', 'dark:bg-gray-800');
                    this.remove();
                }
            });
        });
    });
    
    // Rating stars interaction
    document.querySelectorAll('.rating-stars input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const value = parseInt(this.value);
            const starsContainer = this.closest('.rating-stars');
            
            starsContainer.querySelectorAll('label').forEach((label, index) => {
                const star = label.querySelector('svg');
                if (index < value) {
                    star.classList.add('text-yellow-400');
                    star.classList.remove('text-gray-300', 'dark:text-gray-600');
                    star.setAttribute('fill', 'currentColor');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300', 'dark:text-gray-600');
                    star.setAttribute('fill', 'none');
                }
            });
        });
    });
});