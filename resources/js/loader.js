//ciatocne upravene pomocou AI
export function setupPageLoader()
{
    const loader = document.getElementById('page-loader');
    if (!loader) return;

    const toggleLoader = (isVisible) => loader.classList.toggle('hidden', !isVisible);

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        if (link && link.origin === location.origin && link.target !== '_blank' && !link.hash && !event.ctrlKey && !event.metaKey) {
            toggleLoader(true);
        }
    });

    document.addEventListener('submit', (event) => {
        if (!event.defaultPrevented) toggleLoader(true);
    });

    window.addEventListener('pageshow', () => toggleLoader(false));
}
