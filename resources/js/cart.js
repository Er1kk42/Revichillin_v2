export function setupCart() {

    //JS zachytí klik → pošle požiadavku → server (Laravel) skontroluje token a login → controller → JSON → JS ho spracu
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async () => {
            const res = await sendRequest('POST', button.dataset.url);
            if (res.status === 401) {
                window.location.href = '/login';
                return;
            }
            const data = await res.json();
            if (!res.ok) {
                alert(data.message);
                return;
            }
            const counter = document.querySelector('#cart-count');
            if (counter) counter.textContent = data.count;
            alert(data.message);
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
            response = await sendRequest('POST', `/cart/${row.dataset.productId}`);
        } else if (button.classList.contains('cart-minus')) {
            response = await sendRequest('POST', `/cart/${row.dataset.productId}/remove`);
        } else if (button.classList.contains('cart-remove')) {
            response = await sendRequest('DELETE', `/cart/${row.dataset.itemId}`);
        } else {
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

function sendRequest(method, url) {
    return fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    });
}

function formatPrice(price) {
    return Number(price).toLocaleString('sk-SK', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
}
