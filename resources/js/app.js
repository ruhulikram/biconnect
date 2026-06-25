import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Start Alpine after DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
});

// Handle dark mode persistence via localStorage
// This runs before Alpine to prevent FOUC (flash of unstyled content)
(function() {
    const darkMode = localStorage.getItem('dark_mode');
    if (darkMode === 'true') {
        document.documentElement.classList.add('dark');
    } else if (darkMode === 'false') {
        document.documentElement.classList.remove('dark');
    }
})();
