{{--
    ============================================================================
    HLAVNÝ LAYOUT (spoločná kostra všetkých stránok)
    ----------------------------------------------------------------------------
    Obsahuje to, čo je na každej stránke rovnaké: <head>, horné menu, <main>.
    Konkrétne stránky (napr. welcome.blade.php) ho "dedia" cez
        @extends('layouts.app')
    a do pripravených miest (@yield) vkladajú svoj obsah cez @section.
    Vďaka tomu menu píšeme iba RAZ - zmena sa prejaví na všetkých stránkach.

   --}}
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">

    {{-- Stránka sa na mobile zobrazí v skutočnej šírke zariadenia
         (bez toho by mobil stránku zmenšil ako na desktope) --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Revichillin</title>

    {{-- @vite načíta naše CSS a JS.
         - Počas vývoja (existuje súbor public/hot) vloží odkazy na Vite
           dev server (localhost:5173), ktorý súbory spracúva za behu.
         - V produkcii (po "npm run build") vloží odkazy na hotové súbory
           v public/build (podľa manifest.json). --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- OBRÁZOK NA POZADÍ
     Súbor je v public/img/bckground-test.jpg. Priečinok public/ je koreň webu,
     preto sa v URL NEPÍŠE (správne je /img/..., nie public/img/...).
     Obrázok nastavujeme cez style a asset() namiesto Tailwind triedy bg-[url(...)]:
     trieda by skončila v CSS súbore z Vite servera (localhost:5173) a URL by sa
     hľadala tam, kde obrázok nie je. asset() vždy vygeneruje správnu adresu
     na Laravel server (napr. http://localhost:8000/img/bckground-test.jpg).
     - bg-cover = obrázok vyplní celú plochu bez deformácie
     - bg-center = stred obrázka je v strede obrazovky
     - bg-no-repeat = obrázok sa neopakuje (nekachličkuje)
     - bg-fixed = obrázok stojí na mieste a obsah sa pri scrollovaní posúva ponad neho
     - bg-neutral-950 = záložná tmavá farba, kým sa obrázok nenačíta
     - min-h-screen = stránka je vysoká aspoň ako obrazovka --}}
<body class="bg-neutral-950 bg-cover bg-center bg-no-repeat bg-fixed min-h-screen text-white"
      style="background-image: url('{{ asset('img/bckground-test.jpg') }}')">

{{--
    ============================================================================
    HORNÉ MENU (header)
    - fixed top-0 left-0 w-full = menu je "prilepené" hore a pri scrollovaní
      zostáva na mieste, cez celú šírku obrazovky
    - z-50 = je navrchu nad ostatným obsahom (napr. nad videom)
    - bg-black/30 = čierne pozadie s 30 % nepriehľadnosťou (poloprehľadné)
    - backdrop-blur-sm = rozmaže to, čo je POD menu (efekt matného skla)
    ============================================================================
--}}
<header class="fixed top-0 left-0 w-full z-50 bg-transparent backdrop-blur-sm">

    {{-- flex = prvky vedľa seba v riadku
         items-center = vertikálne zarovnané na stred
         justify-between = logo úplne vľavo, "Prihlásiť sa" úplne vpravo
         px-8 py-5 = vnútorné odsadenie (vodorovne 2rem, zvisle 1.25rem) --}}
    <nav class="flex items-center justify-between px-8 py-5">

        {{-- Logo - odkaz na domovskú stránku --}}
        <a href="/" class="text-xl font-bold tracking-wide">
            REVICHILLIN
        </a>

        {{--
            OBAL PRE POLOŽKY MENU A TLAČIDLO "⋯"
            Tento element meria navigation.js, aby zistil, koľko miesta je k dispozícii.
            - flex-1 = zaberie všetko voľné miesto medzi logom a "Prihlásiť sa"
            - min-w-0 = KĽÚČOVÉ: flexbox predvolene nedovolí, aby bol prvok
              užší ako jeho obsah. Bez min-w-0 by sa obal nikdy nezúžil,
              položky by vytiekli mimo obrazovky a JS by nikdy nezistil,
              že sa nezmestia.
            - justify-center = položky sú v strede voľného miesta
            - gap-14 = medzera 3.5rem (56px) medzi zoznamom a tlačidlom "⋯"
            - mx-8 = odstup od loga a od tlačidla "Prihlásiť sa"
        --}}
        <div id="nav-wrapper" class="flex-1 min-w-0 flex items-center justify-center gap-14 mx-8">

            {{--
                ZOZNAM POLOŽIEK MENU
                - id="nav-items" = podľa neho ho nájde navigation.js
                - gap-14 = medzera medzi položkami (JS ju číta z CSS,
                  takže ju môžeme zmeniť bez úpravy JavaScriptu)
                - uppercase tracking-wider = veľké písmená, väčšie rozostupy písmen

                Atribút data-nav-item označuje položky, s ktorými pracuje JS.
                PORADIE = PRIORITA: položky vľavo zostávajú viditeľné najdlhšie,
                do "⋯" sa presúvajú od konca. Najdôležitejšie odkazy preto patria na začiatok.

                Trieda menu-item je naša vlastná (resources/css/menu.css) -
                animované zväčšenie a zmena farby pri hoveri.
            --}}
            <ul id="nav-items" class="flex gap-14 text-sm font-medium uppercase tracking-wider">
                <li data-nav-item>
                    <a href="/" class="menu-item">
                        Domov
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/products" class="menu-item">
                        Produkty
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>

                {{-- TESTOVACIE POLOŽKY - slúžia len na vyskúšanie, že sa položky
                     presúvajú do "⋯" (pred odovzdaním ich treba odstrániť) --}}
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
                <li data-nav-item>
                    <a href="/contacts" class="menu-item">
                        Kontakt
                    </a>
                </li>
            </ul>

            {{--
                TLAČIDLO "⋯" A ROZBAĽOVACIE MENU
                - relative = rozbaľovacie menu (absolute) sa umiestňuje
                  vzhľadom na tento element (hneď pod tlačidlo)
                - shrink-0 = tlačidlo sa nikdy nezmenší ani nezmizne pri nedostatku miesta
            --}}
            <div class="relative shrink-0">

                {{-- Tlačidlo "⋯"
                     - hidden = na začiatku skryté, JS ho zobrazí, až keď sa položky nezmestia
                     - type="button" = je to obyčajné tlačidlo (nie odoslanie formulára)
                     - menu-item = rovnaký hover efekt ako ostatné položky
                     - cursor-pointer = kurzor "ručička" (Tailwind v4 ho na button nedáva) --}}
                <button id="nav-more-btn" type="button" class="hidden menu-item cursor-pointer">⋯</button>

                {{-- Rozbaľovacie menu - na začiatku PRÁZDNE, JS doň vkladá
                     kópie položiek, ktoré sa nezmestili.
                     - hidden = zatvorené; JS pri otvorení vymení "hidden" za "flex"
                     - absolute right-0 top-full mt-2 = hneď pod tlačidlom,
                       zarovnané k pravému okraju, s malým odstupom
                     - flex-col gap-3 = položky pod sebou s medzerou
                     - whitespace-nowrap = text položky sa nezalomí do dvoch riadkov --}}
                <ul id="nav-more-dropdown" class="hidden absolute right-0 top-full mt-2 bg-black/90 rounded-lg p-4 flex-col gap-3 text-sm font-medium uppercase tracking-wider whitespace-nowrap"></ul>
            </div>

        </div>

        {{-- Tlačidlo prihlásenia
             - rounded-full border = "pilulkový" tvar s orámovaním
             - hover:bg-white hover:text-black = pri hoveri sa farby otočia
             - transition-colors duration-300 = zmena farieb je plynulá (300 ms) --}}
        <a href="/login"
           class="px-5 py-2 rounded-full border border-white/40 text-sm font-medium
                      hover:bg-white hover:text-black transition-colors duration-300">
            Prihlásiť sa
        </a>
    </nav>


</header>

{{--
    HERO SEKCIA (veľký úvodný blok, napr. s videom)
    @hasSection('hero') = vypíše sa iba vtedy, ak ju stránka definuje
    (@section('hero') vo welcome.blade.php). Ostatné stránky hero nemajú,
    a tak sa nevypíše ani prázdny obal.
--}}
@hasSection('hero')
    @yield('hero')
@endif

{{-- HLAVNÝ OBSAH STRÁNKY
     Sem sa vloží obsah z @section('content') konkrétnej stránky.
     <main> je sémantický HTML5 element - hovorí prehliadaču
     a čítačkám obrazovky, kde je hlavný obsah. --}}
<main>
    @yield('content')
</main>

</body>

<footer class="bg-neutral-900 text-white/70 px-8 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- Stĺpec 1: o nás / logo --}}
        <div>
            <h3 class="text-white font-bold text-lg mb-3">REVICHILLIN</h3>
            <p class="text-sm">Tvoj e-shop s nikotínovými produktmi.</p>
        </div>

        {{-- Stĺpec 2: odkazy --}}
        <div>
            <h4 class="text-white font-semibold mb-3">Navigácia</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="/" class="hover:text-orange-400 transition-colors">Domov</a></li>
                <li><a href="/products" class="hover:text-orange-400 transition-colors">Produkty</a></li>
                <li><a href="/contacts" class="hover:text-orange-400 transition-colors">Kontakt</a></li>
            </ul>
        </div>

        {{-- Stĺpec 3: dolezite info --}}
        <div>
            <h4 class="text-white font-semibold mb-3">Info</h4>
            <p class="text-sm">Predaj len osobám nad 18 rokov.</p>
        </div>

    </div>

    <div class="max-w-6xl mx-auto border-t border-white/10 mt-8 pt-6 text-center text-xs">
        &copy; {{ date('Y') }} Revichillin. Všetky práva vyhradené.
    </div>
</footer>
</html>
