// ============================================================================
// NAČÍTAVACIA OBRAZOVKA (page loader)
// ----------------------------------------------------------------------------
// Pri kliknutí na odkaz alebo odoslaní formulára zobrazí točiacu sa ikonu,
// kým prehliadač nenačíta novú stránku.
// HTML (<div id="page-loader">) je v resources/views/layouts/app.blade.php.
// ============================================================================

export function setupPageLoader() {
    const loader = document.getElementById('page-loader');
    if (!loader) return;

    const show = () => loader.classList.replace('hidden', 'flex');

    // Klik na odkaz na našom webe (nie externý, nie do novej karty, nie #kotva).
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href]');
        //e je objekt udalosti, prehliadac ho posle funkcii pri kazdom kliknuti, obsahuje  inf o kliknuti
        // „Zisti, či kliknutie padlo do nejakého odkazu, a ak áno, daj mi ten odkaz.“
        if (link && link.origin === location.origin && link.target !== '_blank' && !link.hash && !e.ctrlKey && !e.metaKey) {
            // ak existuje link, ktory vedie na nasu stranku, neotvara nove okno, neni to konva #odkaz na vrch stranky
            //a nebolo pri tom stlacene ctrt alebo pre mac comand, tak zobraz loader
            show();
        }
    });

    // Odoslanie formulára (login, registrácia...) tiež načíta novú stránku.
    document.addEventListener('submit', show);

    // Po návrate tlačidlom "Späť" môže prehliadač ukázať starú stránku aj so
    // zobrazeným loaderom, preto ho pri udalosti pageshow skryjeme.
    window.addEventListener('pageshow', () => loader.classList.replace('flex', 'hidden'));

    //pageshow a submit, su udalosti prehliadaca, ktore zachytava javascript
}
