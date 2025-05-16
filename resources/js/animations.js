/**
 * Animation utilities for the e-commerce website
 */

// Intersection Observer for revealing elements on scroll
export function initScrollReveal() {
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  };

  const revealCallback = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target;
        const animation = element.dataset.animation || 'fade-in';
        element.classList.add(`animate-${animation}`);
        observer.unobserve(element);
      }
    });
  };

  const revealObserver = new IntersectionObserver(revealCallback, observerOptions);
  
  document.querySelectorAll('[data-animation]').forEach(element => {
    revealObserver.observe(element);
  });
}

// Add to cart animation
export function initAddToCartAnimation() {
  document.addEventListener('click', (event) => {
    const addToCartButton = event.target.closest('[data-add-to-cart]');
    
    if (addToCartButton) {
      // Prevent multiple clicks
      if (addToCartButton.dataset.processing === 'true') return;
      
      addToCartButton.dataset.processing = 'true';
      
      // Add animation class
      addToCartButton.classList.add('animate-pulse');
      
      // Remove animation class after animation completes
      setTimeout(() => {
        addToCartButton.classList.remove('animate-pulse');
        addToCartButton.dataset.processing = 'false';
      }, 1000);
    }
  });
}

// Product image hover zoom effect
export function initProductImageZoom() {
  const productImages = document.querySelectorAll('.product-image-zoom');
  
  productImages.forEach(image => {
    image.addEventListener('mouseenter', () => {
      image.classList.add('scale-105');
      image.classList.add('transition-transform');
      image.classList.add('duration-300');
    });
    
    image.addEventListener('mouseleave', () => {
      image.classList.remove('scale-105');
    });
  });
}

// Smooth page transitions
export function initPageTransitions() {
  document.addEventListener('livewire:navigated', () => {
    const mainContent = document.querySelector('main');
    
    if (mainContent) {
      mainContent.classList.add('animate-fade-in');
      
      setTimeout(() => {
        mainContent.classList.remove('animate-fade-in');
      }, 500);
    }
  });
}

// Hover effects for navigation items
export function initNavHoverEffects() {
  const navItems = document.querySelectorAll('.nav-item');
  
  navItems.forEach(item => {
    item.addEventListener('mouseenter', () => {
      item.classList.add('transition-colors');
      item.classList.add('duration-300');
    });
  });
}

// Initialize all animations
export function initAllAnimations() {
  document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initAddToCartAnimation();
    initProductImageZoom();
    initPageTransitions();
    initNavHoverEffects();
  });
  
  // Also initialize on Livewire page navigation
  document.addEventListener('livewire:navigated', () => {
    initScrollReveal();
    initAddToCartAnimation();
    initProductImageZoom();
    initNavHoverEffects();
  });
}
