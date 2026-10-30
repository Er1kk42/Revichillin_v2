export function showToast(message, isError = false) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.className = 'fixed bottom-6 right-6 z-50 rounded-lg border px-4 py-3 text-sm backdrop-blur transition-opacity duration-300 '
        + (isError
            ? 'border-red-400/30 bg-red-950/80 text-red-300'
            : 'border-green-400/30 bg-green-950/80 text-green-300');

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

export function setupFlash() {
    const flash = document.getElementById('flash');
    if (flash?.dataset.success) {
        showToast(flash.dataset.success);
    }
}
// Ako to funguje:
//   - resources/js/toast.js je nový súbor so showToast(). cart.js ho teraz importuje, takže ho môžeš použiť aj v hocijakom ďalšom JS súbore.
//   - Controller pošle správu cez ->with('status', '...'). Layout ju vypíše do skrytého <div id="flash" data-success="..."> a setupFlash() v app.js z neho po načítaní stránky spraví toast. Funguje to na každej stránke, takže pri
//     ďalšej úspešnej akcii stačí v controlleri pridať ->with('status', '...').
