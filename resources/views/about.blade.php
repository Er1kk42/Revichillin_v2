@extends('layouts.app')

{{--
    STRÁNKA "O NÁS"
    Statická stránka (routes/web.php: Route::view('/about', 'about')).
    Príbeh firmy je FIKTÍVNY – slúži len na ukážku v rámci školského projektu.
--}}
@section('content')
    <section class="page-section">

        {{-- ===== Úvod ===== --}}
        <h1 class="mb-4">O nás</h1>

        {{-- ===== Príbeh + vízia ===== --}}
        <div class="mt-12 grid gap-6 md:grid-cols-2">
            <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-6">
                <h2 class="text-xl font-semibold mb-3">Ako sme vznikli</h2>
                <p class="descriptions mb-3">
                    Revichillin založili v roku 2021 v Žiline dvaja kamaráti, ktorých frustrovalo,
                    že kvalitné nikotínové vrecká sa dali zohnať len ťažko – v obchodoch bol obmedzený
                    výber a e-shopy často ponúkali produkty neznámeho pôvodu.
                </p>
                <p class="descriptions">
                    Začali sme s piatimi produktmi a malým skladom. Dnes ponúkame desiatky produktov
                    od overených značiek a objednávky posielame po celom Slovensku.
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-6">
                <h2 class="text-xl font-semibold mb-3">Prečo to robíme</h2>
                <p class="descriptions mb-3">
                    Chceli sme vytvoriť miesto, kde dospelý zákazník nájde to, čo hľadá, bez zbytočného
                    hľadania a s istotou, že dostane originálny produkt.
                </p>
                <p class="descriptions">
                    Zároveň nám záleží na tom, aby sa naše produkty nedostali do rúk neplnoletým.
                    Preto overujeme vek už pri registrácii a predaj osobám mladším ako 18 rokov odmietame.
                </p>
            </div>
        </div>

        {{-- ===== Vízia ===== --}}
        <div class="mt-6 rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-6">
            <h2 class="text-xl font-semibold mb-3">Naša vízia</h2>
            <p class="descriptions">
                Byť najdôveryhodnejším online obchodom s nikotínovými produktmi na Slovensku –
                s férovými cenami, rýchlym doručením a dôrazom na zodpovedný predaj.
            </p>
        </div>

    </section>
@endsection
