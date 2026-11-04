// Jednoduchý slider bannerov na úvodnej stránke.
// Posúva "track" o 100 % šírky na každý banner a automaticky
// prepína na ďalší banner každé 3 s (po poslednom ide znova prvý).
export function setupSlider()
{
    const slider = document.querySelector('[data-slider]');
    if (!slider) return;

    const track = slider.querySelector('[data-slider-track]');
    const slides = slider.querySelectorAll('[data-slide]');
    if (slides.length < 2) return;

    let current = 0;

    setInterval(() => {
        current = (current + 1) % slides.length;
        track.style.transform = `translateX(-${current * 100}%)`;
    }, 3000);
}
