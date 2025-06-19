/**
 * Слайдер для сервисов на мобильных устройствах
 * 
 * @package RocketBusiness
 */

document.addEventListener('DOMContentLoaded', function() {
    const servicesContainer = document.querySelector('.rb-services__container');
    const dots = document.querySelectorAll('.rb-services__dot');
    
    if (!servicesContainer || dots.length === 0) {
        return;
    }
    
    const serviceItems = servicesContainer.querySelectorAll('.rb-service-item');
    const itemWidth = 280;
    const gap = 16;
    
    function updateActiveDot(index) {
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }
    
    function scrollToSlide(index) {
        const scrollPosition = index * (itemWidth + gap);
        servicesContainer.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            scrollToSlide(index);
            updateActiveDot(index);
        });
    });
    
    servicesContainer.addEventListener('scroll', () => {
        const scrollLeft = servicesContainer.scrollLeft;
        const currentIndex = Math.round(scrollLeft / (itemWidth + gap));
        
        const maxIndex = Math.min(dots.length - 1, serviceItems.length - 1);
        const safeIndex = Math.max(0, Math.min(currentIndex, maxIndex));
        
        updateActiveDot(safeIndex);
    });
    
    function checkMobileAndShowDots() {
        const isMobile = window.innerWidth <= 768;
        const dotsContainer = document.querySelector('.rb-services__dots');
        
        if (dotsContainer) {
            dotsContainer.style.display = isMobile ? 'flex' : 'none';
        }
    }
    
    checkMobileAndShowDots();
    window.addEventListener('resize', checkMobileAndShowDots);
}); 