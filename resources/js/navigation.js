// ============================================================================
// PRIORITY NAVIGATION ("prioritné menu")
// ----------------------------------------------------------------------------
// ČO TO ROBÍ:
// Menu si samo vypočíta, koľko položiek sa zmestí na šírku obrazovky.
// Položky, ktoré sa nezmestia, skryje a presunie do rozbaľovacieho
// menu pod tlačidlom "⋯". Pri zmene veľkosti okna sa výpočet zopakuje.
//
// PREČO:
// Na menších obrazovkách by sa položky inak prekrývali alebo by vytiekli
// mimo obrazovky. Tento vzor (tzv. "priority+ navigation") sa používa
// napr. na stránkach The Guardian či v Gmaile.
//
// AKO TO FUNGUJE (v skratke):
//   1. Zobrazíme všetky položky a zmeriame ich šírky.
//   2. Zmeriame, koľko miesta máme k dispozícii.
//   3. Ak sa všetko zmestí -> hotovo, tlačidlo "⋯" skryjeme.
//   4. Ak nie -> zobrazíme "⋯", odrátame jeho šírku a zľava pridávame
//      položky, kým sa zmestia. Zvyšok skryjeme a jeho kópie vložíme
//      do rozbaľovacieho menu.
//
// Súvisiace HTML je v resources/views/layouts/app.blade.php.
// ============================================================================

// "export" = funkciu môžu používať iné súbory (importuje ju app.js)
export function setupPriorityNav() {

    // ------------------------------------------------------------------------
    // NÁJDENIE ELEMENTOV V HTML
    // document.getElementById('x') vráti element s atribútom id="x",
    // alebo null, ak taký na stránke neexistuje.
    // ------------------------------------------------------------------------

    // Obal (<div id="nav-wrapper">), ktorý zaberá všetko voľné miesto
    // medzi logom a tlačidlom "Prihlásiť sa" (v HTML má flex-1 min-w-0).
    // DÔLEŽITÉ: jeho šírka NEZÁVISÍ od obsahu, ale od veľkosti okna.
    // Preto ju môžeme použiť ako "koľko miesta máme k dispozícii".
    const wrapper = document.getElementById('nav-wrapper');

    // Zoznam položiek menu (<ul id="nav-items">)
    const container = document.getElementById('nav-items');

    // Tlačidlo "⋯", ktoré otvára rozbaľovacie menu
    const moreBtn = document.getElementById('nav-more-btn');

    // Prázdny zoznam (<ul id="nav-more-dropdown">), kam budeme vkladať
    // položky, ktoré sa nezmestili
    const dropdown = document.getElementById('nav-more-dropdown');

    // Ochrana: ak niektorý element na stránke chýba (napr. stránka bez menu),
    // funkciu ukončíme. Inak by kód nižšie spadol na chybe
    // "Cannot read properties of null".
    if (!wrapper || !container || !moreBtn || !dropdown) return;

    // querySelectorAll('[data-nav-item]') nájde všetky elementy s atribútom
    // data-nav-item (sú to <li> položky menu). Vráti NodeList, ktorý
    // Array.from() premení na obyčajné pole - to má metódy ako .map(), .reduce().
    // Atribút data-* používame namiesto triedy, aby bolo jasné, že ho
    // potrebuje JavaScript (a nie je to štýlovanie).
    const items = Array.from(container.querySelectorAll('[data-nav-item]'));


    // ========================================================================
    // HLAVNÁ FUNKCIA - PREPOČET MENU
    // Volá sa pri načítaní stránky, pri zmene veľkosti okna
    // a po načítaní fontu.
    // ========================================================================
    function recalculate() {

        // --------------------------------------------------------------------
        // KROK 1: RESET - vrátime všetko do pôvodného stavu
        // Musíme to urobiť, lebo skrytý element (display: none) má šírku 0
        // a nedal by sa zmerať. Napr. pri zväčšení okna chceme zistiť,
        // či sa už skryté položky zmestia späť.
        // --------------------------------------------------------------------

        // Zobrazíme všetky položky (trieda "hidden" z Tailwindu = display: none).
        // toggle('hidden', podmienka) = ak je podmienka true, trieda sa pridá, inak sa odoberie.
        items.forEach((item) => item.classList.toggle('hidden', false));

        // Vyprázdnime rozbaľovacie menu (odstránime kópie z minulého výpočtu)
        dropdown.innerHTML = '';

        // --------------------------------------------------------------------
        // KROK 2: MERANIE
        // --------------------------------------------------------------------

        // Veľkosť medzery medzi položkami čítame priamo z vypočítaného CSS.
        // getComputedStyle vráti hodnoty tak, ako ich prehliadač naozaj použil,
        // napr. columnGap = "56px" (gap-14 = 3.5rem = 56px).
        // parseFloat("56px") -> 56 (odstráni jednotku a urobí z toho číslo).
        // "|| 0" = ak by hodnota nebola číslo (NaN), použije sa 0.
        // Výhoda: keď v HTML zmeníme gap-14 napr. na gap-8, JS sa prispôsobí
        // sám (pôvodne tu bolo natvrdo 32px, čo nesedelo s gap-14).
        const gap = parseFloat(getComputedStyle(container).columnGap) || 0;

        // Dostupná šírka = vnútorná šírka obalu v pixeloch
        const available = wrapper.clientWidth;

        // Šírka každej položky v pixeloch.
        // .map() vytvorí nové pole - pre každú položku jedno číslo.
        // getBoundingClientRect().width vracia presnú šírku aj s desatinami
        // (offsetWidth zaokrúhľuje na celé pixely a pri veľa položkách
        // by sa chyby zaokrúhlenia sčítali).
        const widths = items.map((item) => item.getBoundingClientRect().width);

        // Celková šírka = súčet šírok všetkých položiek + medzery MEDZI nimi.
        // .reduce() prejde pole a "zhrnie" ho do jednej hodnoty (tu súčet),
        // začína od 0.
        // Medzier je o jednu menej ako položiek (3 položky = 2 medzery).
        const total = widths.reduce((sum, width) => sum + width, 0) + gap * (items.length - 1);

        // --------------------------------------------------------------------
        // KROK 3: VŠETKO SA ZMESTÍ?
        // Ak áno, tlačidlo "⋯" nepotrebujeme - skryjeme ho, zavrieme
        // rozbaľovacie menu a funkciu ukončíme (return).
        // --------------------------------------------------------------------
        const allItemsFit = total <= available;
        moreBtn.classList.toggle('hidden', allItemsFit);

        if (allItemsFit) {
            toggleDropdown(false);
            return;
        }

        // --------------------------------------------------------------------
        // KROK 4: NEZMESTÍ SA - pripravíme miesto pre tlačidlo "⋯"
        // Tlačidlo je už zobrazené (krok 3), takže ho vieme zmerať. Jeho šírku
        // aj medzeru pred ním odrátame z dostupného miesta. Inak by
        // tlačidlo "⋯" samo vytlačilo poslednú položku mimo obrazovky.
        // --------------------------------------------------------------------
        const wrapperGap = parseFloat(getComputedStyle(wrapper).columnGap) || 0;
        const space = available - moreBtn.getBoundingClientRect().width - wrapperGap;

        // --------------------------------------------------------------------
        // KROK 5: ROZDELENIE POLOŽIEK
        // Ideme zľava doprava a sčitujeme šírky. Kým sa zmestia, nechávame
        // ich v menu. Prvá, ktorá by presiahla dostupné miesto, a všetky
        // za ňou idú do rozbaľovacieho menu.
        // Položky vľavo majú teda "prioritu" - preto sa v HTML dávajú
        // najdôležitejšie odkazy na začiatok.
        // --------------------------------------------------------------------
        let used = 0; // koľko miesta sme už "spotrebovali"

        items.forEach((item, index) => {
            // Pripočítame šírku položky + medzeru pred ňou
            // (prvá položka, index = 0, pred sebou medzeru nemá)
            used += widths[index] + (index > 0 ? gap : 0);

            // Položka, ktorá sa nezmestí, sa v hlavnom menu skryje
            const fits = used <= space;
            item.classList.toggle('hidden', !fits);

            if (!fits) {
                // Vytvoríme jej kópiu. cloneNode(true) = "hlboká" kópia,
                // skopíruje aj všetko vnútri (odkaz <a>, text, triedy).
                // Kópiu robíme preto, aby originál ostal na svojom mieste
                // v hlavnom menu - pri zväčšení okna ho len znova zobrazíme.
                const clone = item.cloneNode(true);

                // Originál sme práve skryli, takže aj kópia má triedu "hidden".
                // Tú odstránime, aby bola v rozbaľovacom menu viditeľná.
                clone.classList.toggle('hidden', false);

                // Vložíme kópiu na koniec rozbaľovacieho menu
                dropdown.appendChild(clone);
            }
        });
    }


    // ========================================================================
    // OTVORENIE / ZATVORENIE ROZBAĽOVACIEHO MENU
    // isOpen = true -> menu sa zobrazí, false -> skryje.
    // Dropdown má v HTML natrvalo "flex" (položky pod sebou vďaka flex-col),
    // prepíname len "hidden" (display: none). Samostatná funkcia, lebo menu
    // ovládame z troch miest (recalculate, klik na "⋯", klik mimo).
    // ========================================================================
    function toggleDropdown(isOpen) {
        dropdown.classList.toggle('hidden', !isOpen);
    }


    // ========================================================================
    // KEDY SA MÁ MENU PREPOČÍTAŤ
    // ========================================================================

    // ResizeObserver = sleduje zmenu VEĽKOSTI elementu a pri každej zmene
    // zavolá zadanú funkciu. Je to lepšie ako window 'resize', lebo reaguje
    // na zmenu samotného elementu (nielen okna) a prehliadač ho optimalizuje.
    //
    // Sledujeme OBAL (wrapper), nie zoznam <ul>. Dôvod: skrytím položky
    // by sa <ul> zúžil -> ResizeObserver by znova spustil prepočet ->
    // položka by sa zobrazila -> <ul> by sa rozšíril -> ... a menu by
    // mohlo donekonečna "blikať". Šírka obalu od položiek nezávisí,
    // takže tento cyklus nevznikne.
    new ResizeObserver(recalculate).observe(wrapper);

    // Font Instrument Sans sa sťahuje až po načítaní stránky. Kým nie je
    // stiahnutý, text sa zobrazí záložným fontom, ktorý má inú šírku.
    // Po načítaní fontu sa šírky položiek zmenia, ale šírka obalu nie -
    // ResizeObserver by to teda nezachytil. Preto prepočet spustíme ručne.
    // document.fonts.ready je Promise, ktorý sa splní po načítaní fontov.
    // "?." (optional chaining) = ak by prehliadač document.fonts nepoznal,
    // riadok sa bez chyby preskočí.
    document.fonts?.ready.then(recalculate);


    // ========================================================================
    // OVLÁDANIE ROZBAĽOVACIEHO MENU
    // ========================================================================

    // Klik na "⋯" prepne rozbaľovacie menu (otvorené <-> zatvorené):
    // ak je teraz skryté, otvoríme ho, inak ho zatvoríme.
    moreBtn.addEventListener('click', (event) => {
        // stopPropagation() zastaví "prebublanie" kliknutia vyššie v DOM.
        // Bez toho by klik došiel aj k listeneru na document (nižšie),
        // ten by menu hneď zase zavrel a nikdy by sa neotvorilo.
        event.stopPropagation();

        toggleDropdown(dropdown.classList.contains('hidden'));
    });

    // Klik KDEKOĽVEK na stránke mimo rozbaľovacieho menu ho zavrie
    // (bežné správanie, ktoré používatelia očakávajú).
    // dropdown.contains(event.target) = či kliknutý element leží vnútri menu.
    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) toggleDropdown(false);
    });


    // Prvý výpočet hneď pri načítaní stránky
    // (nečakáme na zmenu veľkosti okna)
    recalculate();
}
