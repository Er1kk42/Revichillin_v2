// ============================================================================
// ÚPRAVA RECENZIE V PROFILE
// ----------------------------------------------------------------------------
// Každá recenzia [data-review] má dva stavy:
//   [data-review-view] = text recenzie s tlačidlami Upraviť / Zmazať
//   [data-review-edit] = formulár na úpravu (na začiatku skrytý)
// Tlačidlo Upraviť zobrazí formulár, Zrušiť ho znova skryje.
// HTML je v resources/views/user.blade.php.
// ============================================================================

export function setupReviewEdit() {
    document.querySelectorAll('[data-review]').forEach((card) => {
        const view = card.querySelector('[data-review-view]');
        const editForm = card.querySelector('[data-review-edit]');

        // isEditing = true -> zobrazí sa formulár, false -> zobrazí sa text recenzie
        const toggleEditing = (isEditing) => {
            view.classList.toggle('hidden', isEditing);
            editForm.classList.toggle('hidden', !isEditing);
        };

        card.querySelector('[data-review-edit-btn]').addEventListener('click', () => toggleEditing(true));
        card.querySelector('[data-review-cancel-btn]').addEventListener('click', () => toggleEditing(false));
    });
}
