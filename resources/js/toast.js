// ============================================================================
// TOAST – krátka správa v pravom dolnom rohu
// ----------------------------------------------------------------------------
// showToast('text')        -> zelená správa (úspech)
// showToast('text', true)  -> červená správa (chyba)
// Správa po 3 sekundách zmizne. Vzhľad je v resources/css/custom.css (.toast).
//
// setupFlash(): controller pošle správu cez ->with('status', '...'), layout ju
// vypíše do skrytého <div id="flash" data-success="..."> a odtiaľ z nej
// po načítaní stránky spravíme toast.
// ============================================================================

export function showToast(message, isError = false) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.className = `toast ${isError ? 'toast-error' : 'toast-success'}`;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.toggle('is-hiding', true);  // spustí CSS prechod (opacity -> 0)
        setTimeout(() => toast.remove(), 300);      // po skončení prechodu element odstránime
    }, 3000);
}

export function setupFlash() {
    const flash = document.getElementById('flash');
    if (flash?.dataset.success) {
        showToast(flash.dataset.success);
    }
}
