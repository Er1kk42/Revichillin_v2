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

    // isVisible = true -> loader sa zobrazí, false -> skryje
    // (trieda "flex" je v HTML natrvalo, prepíname len "hidden")
    const toggleLoader = (isVisible) => loader.classList.toggle('hidden', !isVisible);

    // Klik na odkaz na našom webe (nie externý, nie do novej karty, nie #kotva).
    document.addEventListener('click', (event) => {
        const link = event.target.closest('a[href]');
        //event je objekt udalosti, prehliadac ho posle funkcii pri kazdom kliknuti, obsahuje  inf o kliknuti
        // „Zisti, či kliknutie padlo do nejakého odkazu, a ak áno, daj mi ten odkaz.“
        if (link && link.origin === location.origin && link.target !== '_blank' && !link.hash && !event.ctrlKey && !event.metaKey) {
            // ak existuje link, ktory vedie na nasu stranku, neotvara nove okno, neni to konva #odkaz na vrch stranky
            //a nebolo pri tom stlacene ctrt alebo pre mac comand, tak zobraz loader
            toggleLoader(true);
        }
    });

    // Odoslanie formulára (login, registrácia...) tiež načíta novú stránku.
    // defaultPrevented = odoslanie niekto zrušil (validácia v validation.js našla chybu,
    // alebo používateľ dal "Zrušiť" v confirm() pri mazaní recenzie) – vtedy sa
    // žiadna nová stránka nenačíta, takže loader nezobrazíme.
    document.addEventListener('submit', (event) => {
        if (!event.defaultPrevented) toggleLoader(true);
    });

    // Po návrate tlačidlom "Späť" môže prehliadač ukázať starú stránku aj so
    // zobrazeným loaderom, preto ho pri udalosti pageshow skryjeme.
    window.addEventListener('pageshow', () => toggleLoader(false));

    //pageshow a submit, su udalosti prehliadaca, ktore zachytava javascript
}
