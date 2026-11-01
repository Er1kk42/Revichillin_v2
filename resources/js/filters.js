// ============================================================================
// FILTRE PRODUKTOV
// ----------------------------------------------------------------------------
// 1. Tlačidlá [data-filter] otvárajú a zatvárajú panely s filtrami [data-filter-panel].
// 2. Posuvníky (sila, cena) priebežne vypisujú svoju hodnotu do <output>.
// 3. Pri každej zmene filtra stiahneme stránku s novými výsledkami a vymeníme
//    len zoznam produktov – stránka sa celá nenačítava znova.
// HTML je v resources/views/products/index.blade.php.
// ============================================================================

export function setupFilters() {
    const filters = document.getElementById('filters');
    if (!filters) return;

    const panels = Array.from(filters.querySelectorAll('[data-filter-panel]'));

    // Klik na záložku: jej panel sa prepne (otvorí/zatvorí), všetky ostatné sa zatvoria.
    filters.querySelectorAll('[data-filter]').forEach((tab) => {
        tab.addEventListener('click', () => {
            panels.forEach((panel) => {
                const isTargetPanel = panel.dataset.filterPanel === tab.dataset.filter;
                panel.classList.toggle('hidden', !isTargetPanel || !panel.classList.contains('hidden'));
            });
        });
    });

    // Posuvník -> hneď za ním je <output>, kam vypíšeme aktuálnu hodnotu.
    filters.querySelectorAll('input[type="range"]').forEach((range) => {
        range.addEventListener('input', () => {
            range.nextElementSibling.value = range.value;
        });
    });

    // Pri zmene filtra poskladáme URL s filtrami (napr. /products?brand[]=x&price=10),
    // stiahneme z nej HTML a vymeníme iba obsah #product-list.
    // FormData zozbiera hodnoty z formulára, URLSearchParams ich prevedie na text pre URL.
    filters.addEventListener('change', async () => {
        const url = `${filters.action}?${new URLSearchParams(new FormData(filters))}`;

        const response = await fetch(url);
        if (!response.ok) return;

        // DOMParser premení text (HTML) na dokument, v ktorom vieme hľadať elementy.
        const html = await response.text();
        const newList = new DOMParser().parseFromString(html, 'text/html').getElementById('product-list');

        document.getElementById('product-list').innerHTML = newList.innerHTML;

        // Zmeníme URL v prehliadači (bez načítania stránky), aby filtre ostali aj po F5.
        history.replaceState(null, '', url);
    });
}
