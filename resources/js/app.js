// ============================================================================
// HLAVNÝ JAVASCRIPT SÚBOR APLIKÁCIE
// ----------------------------------------------------------------------------
// Rovnako ako app.css je aj tento súbor "vstupný bod" (input vo vite.config.js)
// a načítava sa v layoute cez @vite([...]).
//
// Samotnú logiku nepíšeme priamo sem, ale do samostatných súborov (modulov).
// Tu ich iba importujeme a spúšťame. Kód je tak rozdelený podľa funkcií
// a je prehľadnejší - napr. všetko o menu je v navigation.js.
// ============================================================================

// Import funkcie z modulu navigation.js.
// Funguje to vďaka ES modulom: v navigation.js je funkcia označená
// slovom "export", a tu ju cez "import" sprístupníme.
import { setupPriorityNav } from './navigation.js';
import { setupCart } from './cart.js';
import { setupFlash } from './toast.js';


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
