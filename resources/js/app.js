import './bootstrap';
import 'preline';
import { initAllAnimations } from './animations';

// Handle navbar visibility and scroll behavior
document.addEventListener('DOMContentLoaded', () => {
    initNavbarScrollBehavior();
});

// Initialize Preline UI components and handle navigation
document.addEventListener('livewire:navigated', () => {
    // Re-initialize Preline components after navigation
    window.HSStaticMethods.autoInit();

    // Re-initialize navbar behavior after navigation
    initNavbarScrollBehavior();

    // Scroll to top on page navigation
    window.scrollTo(0, 0);
});

// Initialize all custom animations
initAllAnimations();

// Function to handle navbar scroll behavior
function initNavbarScrollBehavior() {
    const navbar = document.querySelector('header');
    if (!navbar) return;

    let lastScrollTop = 0;

    // Set initial state
    navbar.classList.add('transition-transform', 'duration-300');

    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Add shadow and background opacity when scrolling down
        if (scrollTop > 10) {
            navbar.classList.add('shadow-md', 'bg-white/95', 'dark:bg-gray-900/95');
        } else {
            navbar.classList.remove('shadow-md', 'bg-white/95', 'dark:bg-gray-900/95');
        }

        // Always ensure the navbar is visible and not transformed
        navbar.style.transform = 'translateY(0)';

        lastScrollTop = scrollTop;
    });
}