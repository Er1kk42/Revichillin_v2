export function setupCart() {
    // TODO: načítať CSRF token z <meta name="csrf-token"> a posielať ho v hlavičke X-CSRF-TOKEN
    //       spolu s 'Accept: application/json' pri každom POST/PATCH/DELETE

    // TODO: "Pridať do košíka" (produkty, detail produktu) – fetch POST /cart s product_id a quantity
    //       - počas requestu vypnúť tlačidlo (loading stav)
    //       - po úspechu aktualizovať počítadlo v hlavičke a zobraziť toast
    //       - pri 401 (neprihlásený) presmerovať na /login

    // TODO: tlačidlá +/− v košíku – fetch PATCH /cart/{item}, prepísať cenu položky a celkovú sumu

    // TODO: tlačidlo odstrániť v košíku – fetch DELETE /cart/{item}, odstrániť riadok,
    //       prepočítať sumu, pri prázdnom košíku zobraziť prázdny stav

    // TODO: ošetriť chyby (napr. nedostatok na sklade, výpadok siete) – zobraziť toast s chybou
}
