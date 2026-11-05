//ciatocne upravene pomocou AI
export function setupValidation()
{
    document.querySelectorAll('form[data-validate]').forEach(setupForm);
}

const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function setupForm(form)
{
    form.noValidate = true;

    const fields = Array.from(form.querySelectorAll('input:not([type="hidden"]), textarea'));

    form.addEventListener('submit', (event) => {
        let firstInvalid = null;

        fields.forEach((input) => {
            const message = validateField(input, form);
            showError(input, message);
            if (message && !firstInvalid) {
                firstInvalid = input;
            }
        });

        if (firstInvalid) {
            event.preventDefault();
            firstInvalid.focus();
        }
    })

    fields.forEach((input) => {
        input.addEventListener('blur', () => {
            if (input.value.trim() !== '') {
                showError(input, validateField(input, form));
            }
        });

        input.addEventListener('input', () => {
            if (input.classList.contains('is-invalid')) {
                showError(input, validateField(input, form));
            }
        });
    });
}

function validateField(input, form)
{
    const value = input.value.trim();
    const label = getLabel(input);
    const name = label ? `Pole „${label}“` : 'Toto pole';

    if (input.required && value === '') {
        return `${name} je povinné.`;
    }

    const requiredWith = input.dataset.requiredWith;
    if (requiredWith && value === '' && form.elements[requiredWith]?.value !== '') {
        return 'Pre zmenu hesla zadaj staré heslo.';
    }

    if (value === '') {
        return null;
    }

    if (input.type === 'email' && !EMAIL_REGEX.test(value)) {
        return 'Zadaj platný e-mail (napr. meno@domena.sk).';
    }

    if (input.minLength > 0 && value.length < input.minLength) {
        return `${name} musí mať aspoň ${input.minLength} znakov.`;
    }
    if (input.maxLength > 0 && value.length > input.maxLength) {
        return `${name} môže mať najviac ${input.maxLength} znakov.`;
    }

    const minAge = Number(input.dataset.minAge);
    if (minAge && value > dateYearsAgo(minAge)) {
        return `Musíš mať aspoň ${minAge} rokov.`;
    }

    const match = input.dataset.match;
    if (match && value !== form.elements[match]?.value.trim()) {
        return 'Heslá sa nezhodujú.';
    }

    return null;
}

function getLabel(input)
{
    const label = input.id ? document.querySelector(`label[for="${input.id}"]`) : null;
    return label ? label.textContent.trim() : null;
}

function dateYearsAgo(years)
{
    const date = new Date();
    date.setFullYear(date.getFullYear() - years);

    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${date.getFullYear()}-${month}-${day}`;
}

function showError(input, message)
{
    input.parentElement.querySelectorAll(':scope > .form-error').forEach((element) => element.remove());

    input.classList.toggle('is-invalid', message !== null);

    input.setAttribute('aria-invalid', message !== null ? 'true' : 'false');

    if (message !== null) {
        const error = document.createElement('p');
        error.className = 'form-error';
        error.textContent = message;
        input.insertAdjacentElement('afterend', error);
    }
}


