//ciatocne upravene pomocou AI
export function setupReviewEdit()
{
    document.querySelectorAll('[data-review]').forEach((card) => {
        const view = card.querySelector('[data-review-view]');
        const editForm = card.querySelector('[data-review-edit]');

        const toggleEditing = (isEditing) => {
            view.classList.toggle('hidden', isEditing);
            editForm.classList.toggle('hidden', !isEditing);
        };

        card.querySelector('[data-review-edit-btn]').addEventListener('click', () => toggleEditing(true));
        card.querySelector('[data-review-cancel-btn]').addEventListener('click', () => toggleEditing(false));
    });
}
