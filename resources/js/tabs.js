export function setupTabs()
{
    const tabs = Array.from(document.querySelectorAll('[data-tab]'));
    if (tabs.length === 0) return;

    const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

    tabs.forEach((tab) => {
        tab.addEventListener('click', (event) => {
            event.preventDefault();

            panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== tab.dataset.tab));
        });
    });

    document.querySelector(`[data-tab="${location.hash.slice(1)}"]`)?.click();
}
