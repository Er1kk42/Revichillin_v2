// ============================================================================
// VALIDÁCIA FORMULÁROV NA STRANE KLIENTA
// ----------------------------------------------------------------------------
// Kontroluje vstupy ešte PRED odoslaním na server, aby používateľ hneď videl
// chybu a nemusel čakať na odpoveď servera.
//
// DÔLEŽITÉ: klientská validácia je len pre pohodlie používateľa. Dá sa
// obísť (vypnutý JS, úprava HTML v DevTools, poslanie požiadavky cez curl),
// preto ROVNAKÉ pravidlá kontroluje aj server (Form Requesty v
// app/Http/Requests a $request->validate() v controlleroch).
//
// Ako to použiť:
//   1. <form data-validate> = formulár, ktorý sa má kontrolovať
//   2. pravidlá sa píšu priamo k poľu ako HTML atribúty:
//        required                    pole je povinné
//        type="email"                musí to byť platný e-mail
//        minlength="8"               minimálny počet znakov
//        maxlength="255"             maximálny počet znakov
//        data-match="password"       hodnota sa musí zhodovať s poľom name="password"
//        data-min-age="18"           (dátum) používateľ musí mať aspoň 18 rokov
//        data-required-with="password"  povinné, ak je vyplnené pole name="password"
//
// Prečo HTML atribúty? Ak by JS nefungoval, prehliadač ich skontroluje sám
// (vstavaná HTML5 validácia). Keď JS beží, vstavanú validáciu vypneme
// (noValidate) a zobrazíme vlastné slovenské hlášky v našom dizajne.
// ============================================================================


// Jednoduchý regulárny výraz pre e-mail: "niečo@niečo.niečo" bez medzier.
// [^\s@]+ = aspoň jeden znak, ktorý nie je medzera ani @
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


/**
 * Nájde text popisku (<label for="id">) k poľu, aby hláška znela
 * napr. "Pole „E-mail“ je povinné." Ak popisok nemá, vráti null.
 */
function getLabel(input) {
    const label = input.id ? document.querySelector(`label[for="${input.id}"]`) : null;
    return label ? label.textContent.trim() : null;
}


/**
 * Vráti dnešný dátum posunutý o `years` rokov dozadu vo formáte RRRR-MM-DD.
 * Rovnaký formát posiela <input type="date">, takže dátumy vieme porovnať
 * ako obyčajné texty ("2006-05-01" < "2007-01-01").
 */
function dateYearsAgo(years) {
    const date = new Date();
    date.setFullYear(date.getFullYear() - years);

    // padStart(2, '0') doplní nulu: 5 -> "05"
    const month = String(date.getMonth() + 1).padStart(2, '0'); // mesiace sú v JS od 0
    const day = String(date.getDate()).padStart(2, '0');
    return `${date.getFullYear()}-${month}-${day}`;
}


/**
 * Skontroluje jedno pole podľa jeho atribútov.
 * Vráti text chyby, alebo null, ak je pole v poriadku.
 * Pravidlá sa kontrolujú postupne – vráti sa PRVÁ nájdená chyba.
 */
function validateField(input, form) {
    const value = input.value.trim();      // trim() = ignorujeme medzery na začiatku a konci
    const label = getLabel(input);
    const name = label ? `Pole „${label}“` : 'Toto pole';

    // 1) Povinné pole
    if (input.required && value === '') {
        return `${name} je povinné.`;
    }

    // 2) Povinné, ak je vyplnené iné pole (staré heslo pri zmene hesla v profile)
    const requiredWith = input.dataset.requiredWith;
    if (requiredWith && value === '' && form.elements[requiredWith]?.value !== '') {
        return 'Pre zmenu hesla zadaj staré heslo.';
    }

    // Ostatné pravidlá má zmysel kontrolovať, len keď niečo je vyplnené
    // (napr. nepovinné "Nové heslo" v profile môže ostať prázdne).
    if (value === '') {
        return null;
    }

    // 3) Formát e-mailu
    if (input.type === 'email' && !EMAIL_REGEX.test(value)) {
        return 'Zadaj platný e-mail (napr. meno@domena.sk).';
    }

    // 4) Minimálna a maximálna dĺžka (minLength/maxLength vracajú -1, ak atribút chýba)
    if (input.minLength > 0 && value.length < input.minLength) {
        return `${name} musí mať aspoň ${input.minLength} znakov.`;
    }
    if (input.maxLength > 0 && value.length > input.maxLength) {
        return `${name} môže mať najviac ${input.maxLength} znakov.`;
    }

    // 5) Minimálny vek (dátum narodenia nesmie byť neskôr ako "dnes pred 18 rokmi")
    const minAge = Number(input.dataset.minAge);
    if (minAge && value > dateYearsAgo(minAge)) {
        return `Musíš mať aspoň ${minAge} rokov.`;
    }

    // 6) Zhoda s iným poľom (potvrdenie hesla)
    const match = input.dataset.match;
    if (match && value !== form.elements[match]?.value.trim()) {
        return 'Heslá sa nezhodujú.';
    }

    return null;
}


/**
 * Zobrazí chybu pod poľom (alebo ju odstráni, ak message je null).
 * Zároveň odstráni starú chybu zo servera (@error v Blade), aby sa
 * pod poľom neukazovali dve hlášky naraz.
 */
function showError(input, message) {
    // :scope > .form-error = len chyby priamo v rovnakom obale ako pole
    input.parentElement.querySelectorAll(':scope > .form-error').forEach((element) => element.remove());

    // classList.toggle(trieda, podmienka) = pridá triedu, ak je podmienka true, inak ju odoberie
    input.classList.toggle('is-invalid', message !== null);

    // aria-invalid = informácia pre čítačky obrazovky (prístupnosť)
    input.setAttribute('aria-invalid', message !== null ? 'true' : 'false');

    if (message !== null) {
        const error = document.createElement('p');
        error.className = 'form-error';
        error.textContent = message;          // textContent (nie innerHTML) = bezpečné voči XSS
        input.insertAdjacentElement('afterend', error); // hneď za pole
    }
}


/**
 * Pripojí validáciu k jednému formuláru.
 */
function setupForm(form) {
    // Vypneme vstavané bubliny prehliadača – chyby zobrazujeme sami.
    form.noValidate = true;

    // Všetky polia, ktoré sa dajú kontrolovať (okrem tlačidiel a skrytých polí ako _token)
    const fields = Array.from(form.querySelectorAll('input:not([type="hidden"]), textarea'));

    // a) Pri ODOSLANÍ skontrolujeme všetky polia naraz.
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
            event.preventDefault();   // formulár sa NEODOŠLE na server
            firstInvalid.focus();     // kurzor skočí do prvého chybného poľa
        }
    });

    fields.forEach((input) => {
        // b) Pri OPUSTENÍ poľa (blur) skontrolujeme len to jedno pole,
        //    ale iba ak v ňom niečo je – nechceme kričať "povinné" pri prvom prekliknutí.
        input.addEventListener('blur', () => {
            if (input.value.trim() !== '') {
                showError(input, validateField(input, form));
            }
        });

        // c) Počas PÍSANIA – ak je pole označené ako chybné, kontrolujeme priebežne,
        //    aby chyba zmizla hneď, ako ju používateľ opraví.
        input.addEventListener('input', () => {
            if (input.classList.contains('is-invalid')) {
                showError(input, validateField(input, form));
            }
        });
    });
}


/**
 * Spustí validáciu pre všetky formuláre s atribútom data-validate na stránke.
 * Volá sa z app.js po načítaní stránky (DOMContentLoaded).
 */
export function setupValidation() {
    document.querySelectorAll('form[data-validate]').forEach(setupForm);
}
