//ciatocne upravene pomocou AI
import { showToast } from './toast.js';

export function setupCart()
{
    document.addEventListener('click', async (event) => {
        const button = event.target.closest('[data-cart-add]');
        if (!button) return;

        const response = await sendRequest('POST', button.dataset.url, button);
        if (response.status === 401) {
            showToast('Pre pridanie do košíka sa musíš prihlásiť.', true);
            setTimeout(() => window.location.href = document.querySelector('meta[name="login-url"]').content, 1500);
            return;
        }
        const data = await response.json();
        if (!response.ok) {
            showToast(data.message, true);
            return;
        }
        showToast(data.message);
    });

    const list = document.getElementById('cart-list');
    if (!list) return;

    list.addEventListener('click', async (event) => {
        const button = event.target.closest('button[data-url]');
        const row = event.target.closest('[data-cart-item]');
        if (!button || !row) return;

        const response = await sendRequest(button.dataset.method ?? 'POST', button.dataset.url, button);
        const data = await response.json();
        if (!response.ok) {
            showToast(data.message, true);
            return;
        }

        if (data.quantity > 0) {
            row.querySelector('[data-cart-quantity]').textContent = data.quantity;
            row.querySelector('[data-cart-item-total]').textContent = formatPrice(data.item_total);
        } else {
            row.remove();
        }

        document.getElementById('cart-total').textContent = formatPrice(data.cart_total);

        if (data.cart_count === 0) {
            list.innerHTML = '<li class="text-white/60">Tvoj košík je prázdny.</li>';
            document.getElementById('cart-summary').remove();
            document.getElementById('cart-empty').classList.toggle('hidden', false);
        }
    });
}

async function sendRequest(method, url, button)
{
    const toggleLoading = (isLoading) => {
        button.disabled = isLoading;
        button.classList.toggle('is-loading', isLoading);
    };

    toggleLoading(true);

    try {
        return await fetch(url, {
            method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });
    } finally {
        toggleLoading(false);
    }
}

function formatPrice(price)
{
    const formatted = Number(price).toLocaleString('sk-SK', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    return `${formatted} €`;
}
