// ============================================================================
// HLAVNÝ JAVASCRIPT SÚBOR APLIKÁCIE
// ----------------------------------------------------------------------------
// Rovnako ako app.css je aj tento súbor "vstupný bod" (input vo vite.config.js)
// a načítava sa v layoute cez @vite([...]).
//
// Samotnú logiku nepíšeme priamo sem, ale do samostatných súborov (modulov).
// Tu ich iba importujeme a spúšťame. Kód je tak rozdelený podľa funkcií
// a je prehľadnejší - napr. všetko o menu je v navigation.js.
//
// Pravidlá, ktoré platia vo všetkých moduloch:
//   - JS hľadá elementy podľa id (jedinečné prvky, napr. #cart-list) alebo
//     podľa data-* atribútov (napr. [data-cart-add]). CSS triedy slúžia len
//     na vzhľad, takže zmena dizajnu nerozbije JavaScript.
//   - Listener dávame priamo na elementy. Výnimkou je obsah, ktorý sa mení
//     cez AJAX (zoznam produktov, košík) – tam listener dávame na rodiča
//     (delegovanie udalosti), aby fungoval aj pre nové elementy.
// ============================================================================

// Import funkcie z modulu navigation.js.
// Funguje to vďaka ES modulom: v navigation.js je funkcia označená
// slovom "export", a tu ju cez "import" sprístupníme.
import { setupPriorityNav } from './navigation.js';
import { setupCart } from './cart.js';
import { setupFlash } from './toast.js';
import { setupPageLoader } from './loader.js';
import { setupValidation } from './validation.js';
import { setupTabs } from './tabs.js';
import { setupReviewEdit } from './reviews.js';
import { setupConfirm } from './confirm.js';
import { setupFilters } from './filters.js';


// DOMContentLoaded = udalosť, ktorá nastane, keď prehliadač načíta
// a spracuje celú HTML štruktúru stránky (DOM).
// Až vtedy existujú elementy ako #nav-items, ktoré funkcia hľadá.
// Keby sme ju spustili skôr, getElementById by vrátil null.
//
// Všimni si, že odovzdávame len NÁZOV funkcie (setupPriorityNav),
// nie jej volanie (setupPriorityNav()). Prehliadač ju zavolá sám,
// keď udalosť nastane.
document.addEventListener('DOMContentLoaded', setupPriorityNav);
document.addEventListener('DOMContentLoaded', setupCart);
document.addEventListener('DOMContentLoaded', setupFlash);
document.addEventListener('DOMContentLoaded', setupPageLoader);
document.addEventListener('DOMContentLoaded', setupValidation);
document.addEventListener('DOMContentLoaded', setupTabs);
document.addEventListener('DOMContentLoaded', setupReviewEdit);
document.addEventListener('DOMContentLoaded', setupConfirm);
document.addEventListener('DOMContentLoaded', setupFilters);
