// ============================================================================
// POTVRDENIE PRED ODOSLANÍM FORMULÁRA
// ----------------------------------------------------------------------------
// <form data-confirm="Naozaj chceš zmazať túto recenziu?"> sa odošle, až keď
// používateľ v okne confirm() klikne na OK. Pri "Zrušiť" sa odoslanie zastaví.
//
// Listener dávame priamo na formulár (nie na document), aby sa spustil skôr ako
// listener v loader.js – ten podľa event.defaultPrevented zistí, že sa formulár
// neodoslal, a načítavaciu obrazovku nezobrazí.
// ============================================================================

export function setupConfirm() {
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
}
