export function setupPriorityNav()
{
    const wrapper = document.getElementById('nav-wrapper');
    const container = document.getElementById('nav-items');
    const moreBtn = document.getElementById('nav-more-btn');
    const dropdown = document.getElementById('nav-more-dropdown');

    if (!wrapper || !container || !moreBtn || !dropdown) return;

    const items = Array.from(container.querySelectorAll('[data-nav-item]'));

    function recalculate()
    {
        items.forEach((item) => item.classList.toggle('hidden', false));

        dropdown.innerHTML = '';

        const gap = parseFloat(getComputedStyle(container).columnGap) || 0;
        const available = wrapper.clientWidth;
        const widths = items.map((item) => item.getBoundingClientRect().width);
        const total = widths.reduce((sum, width) => sum + width, 0) + gap * (items.length - 1);
        const allItemsFit = total <= available;
        moreBtn.classList.toggle('hidden', allItemsFit);

        if (allItemsFit) {
            toggleDropdown(false);
            return;
        }

        const wrapperGap = parseFloat(getComputedStyle(wrapper).columnGap) || 0;
        const space = available - moreBtn.getBoundingClientRect().width - wrapperGap;

        let used = 0;

        items.forEach((item, index) => {
            used += widths[index] + (index > 0 ? gap : 0);

            const fits = used <= space;
            item.classList.toggle('hidden', !fits);

            if (!fits) {
                const clone = item.cloneNode(true);

                clone.classList.toggle('hidden', false);

                dropdown.appendChild(clone);
            }
        });
    }

    function toggleDropdown(isOpen)
    {
        dropdown.classList.toggle('hidden', !isOpen);
    }

    new ResizeObserver(recalculate).observe(wrapper);

    document.fonts?.ready.then(recalculate);

    moreBtn.addEventListener('click', (event) => {
        event.stopPropagation();

        toggleDropdown(dropdown.classList.contains('hidden'));
    });

    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) toggleDropdown(false);
    });

    recalculate();
}
