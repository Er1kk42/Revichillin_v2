import { showToast } from './toast.js';

export function setupCart() {

    //JS zachytí klik → pošle požiadavku → server (Laravel) skontroluje token a login → controller → JSON → JS ho spracu
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async () => {
            const res = await sendRequest('POST', button.dataset.url, button);
            if (res.status === 401) {
                showToast('Pre pridanie do košíka sa musíš prihlásiť.', true);
                setTimeout(() => window.location.href = '/login', 1500);
                return;
            }
            const data = await res.json();
            if (!res.ok) {
                showToast(data.message, true);
                return;
            }
            const counter = document.querySelector('#cart-count');
            if (counter) counter.textContent = data.count;
            showToast(data.message);
        });
    });

    const list = document.getElementById('cart-list');
    if (!list) return;

    list.addEventListener('click', async (event) => {
        const button = event.target.closest('button');
        const row = event.target.closest('.cart-item');
        if (!button || !row) return;

        let response;
        if (button.classList.contains('cart-plus')) {
            response = await sendRequest('POST', `/cart/${row.dataset.productId}`, button);
        } else if (button.classList.contains('cart-minus')) {
            response = await sendRequest('POST', `/cart/${row.dataset.productId}/remove`, button);
        } else if (button.classList.contains('cart-remove')) {
            response = await sendRequest('DELETE', `/cart/${row.dataset.itemId}`, button);
        } else {
            return;
        }

        const data = await response.json();
        if (!response.ok) {
            showToast(data.message, true);
            return;
        }

        if (data.quantity > 0) {
            row.querySelector('.cart-quantity').textContent = data.quantity;
            row.querySelector('.cart-item-total').textContent = formatPrice(data.item_total);
        } else {
            row.remove();
        }

        document.getElementById('cart-total').textContent = formatPrice(data.cart_total);

        if (data.cart_count === 0) {
            list.innerHTML = '<li class="text-white/60">Tvoj košík je prázdny.</li>';
            document.getElementById('cart-summary').remove();
            document.getElementById('cart-empty').classList.remove('hidden');
        }
    });
}

async function sendRequest(method, url, button) {
    button.disabled = true;
    button.classList.add('is-loading');

    try {
        return await fetch(url, {
            method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        });
    } finally {
        button.disabled = false;
        button.classList.remove('is-loading');
    }
}

function formatPrice(price) {
    return Number(price).toLocaleString('sk-SK', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
}
