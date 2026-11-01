// ============================================================================
// ZÁLOŽKY V PROFILE (Profil / História objednávok / Moje recenzie)
// ----------------------------------------------------------------------------
// Klik na záložku zobrazí jej panel a ostatné skryje.
// Záložka má data-tab="orders", jej panel má data-tab-panel="orders".
// HTML je v resources/views/user.blade.php.
// ============================================================================

export function setupTabs() {
    const tabs = Array.from(document.querySelectorAll('[data-tab]'));
    if (tabs.length === 0) return;

    const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

    tabs.forEach((tab) => {
        tab.addEventListener('click', (event) => {
            event.preventDefault();

            // toggle('hidden', podmienka) = ak panel nepatrí ku kliknutej záložke, skryje sa, inak sa zobrazí
            panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== tab.dataset.tab));
        });
    });

    // Ak URL končí napr. na #orders (presmerovanie po objednávke), otvoríme rovno túto záložku.
    document.querySelector(`[data-tab="${location.hash.slice(1)}"]`)?.click();
}
