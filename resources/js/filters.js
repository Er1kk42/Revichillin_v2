//ciatocne upravene pomocou AI
export function setupFilters()
{
    const filters = document.getElementById('filters');
    if (!filters) return;

    const panels = Array.from(filters.querySelectorAll('[data-filter-panel]'));

    filters.querySelectorAll('[data-filter]').forEach((tab) => {
        tab.addEventListener('click', () => {
            panels.forEach((panel) => {
                const isTargetPanel = panel.dataset.filterPanel === tab.dataset.filter;
                panel.classList.toggle('hidden', !isTargetPanel || !panel.classList.contains('hidden'));
            });
        });
    });

    filters.querySelectorAll('input[type="range"]').forEach((range) => {
        range.addEventListener('input', () => {
            range.nextElementSibling.value = range.value;
        });
    });

    filters.addEventListener('change', async () => {
        const url = `${filters.action}?${new URLSearchParams(new FormData(filters))}`;
        const response = await fetch(url);
        if (!response.ok) return;

        const html = await response.text();
        const newList = new DOMParser().parseFromString(html, 'text/html').getElementById('product-list');

        document.getElementById('product-list').innerHTML = newList.innerHTML;

        history.replaceState(null, '', url);
    });
}
