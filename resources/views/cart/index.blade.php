@extends('layouts.app')

@section('content')
    <section class="max-w-5xl mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Košík</h1>

        {{-- TODO: @forelse cez položky košíka – riadok s obrázkom, názvom, cenou za kus,
                   tlačidlami +/− (PATCH cez AJAX), cenou položky a tlačidlom odstrániť (DELETE cez AJAX).
                   Každý riadok označiť data-item-id, aby ho JS vedel nájsť a aktualizovať. --}}

        {{-- TODO: @empty – prázdny stav: "Tvoj košík je prázdny" + tlačidlo "Pokračovať v nákupe" (/products) --}}

        {{-- TODO: súhrn – celková suma (id pre aktualizáciu z JS) a tlačidlo "Pokračovať k objednávke" --}}
    </section>
@endsection
