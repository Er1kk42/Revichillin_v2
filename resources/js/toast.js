//ciatocne upravene pomocou AI
export function showToast(message, isError = false)
{
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.className = `toast ${isError ? 'toast-error' : 'toast-success'}`;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.toggle('is-hiding', true);
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

export function setupFlash()
{
    const flash = document.getElementById('flash');
    if (flash?.dataset.success) {
        showToast(flash.dataset.success);
    }
}
