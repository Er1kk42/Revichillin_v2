@extends('layouts.app')

{{--
    KONTAKTNÁ STRÁNKA
    Statická stránka (route v routes/web.php vracia len view('contacts')).
    Všetky údaje sú FIKTÍVNE – slúžia len na ukážku v rámci školského projektu.

    Údaje sú v PHP poliach na začiatku šablóny a HTML ich len vypisuje cez @foreach.
    Keď treba niečo zmeniť (napr. otváracie hodiny), stačí upraviť pole,
    HTML sa nemení.
--}}
@php
    $company = [
        'Obchodné meno' => 'Revichillin s.r.o.',
        'Sídlo' => 'Chillová 42, 010 01 Žilina',
        'IČO' => '12 345 678',
        'DIČ' => '2012345678',
        'IČ DPH' => 'SK2012345678',
        'Zápis' => 'Obchodný register Okresného súdu Žilina, oddiel Sro, vložka č. 00000/L',
        'IBAN' => 'SK00 0000 0000 0000 0000 0000',
    ];

    $openingHours = [
        'Pondelok – Piatok' => '9:00 – 18:00',
        'Sobota' => '9:00 – 12:00',
        'Nedeľa a sviatky' => 'zatvorené',
    ];
@endphp

@section('content')
    <section class="page-section">
        <h1 class="mb-4">Kontakt</h1>
        <p class="descriptions mb-10 max-w-2xl">
            Máte otázku k objednávke, produktu alebo reklamácii? Ozvite sa nám e-mailom alebo telefonicky
            počas pracovných hodín – odpovedáme spravidla do 24 hodín.
        </p>

        {{-- ===== Horný riadok: rýchly kontakt + údaje o firme ===== --}}
        <div class="grid gap-6 md:grid-cols-2">

            {{-- Rýchly kontakt a otváracie hodiny --}}
            <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-6">
                <h2 class="text-xl font-semibold mb-4">Napíšte alebo zavolajte</h2>

                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-white/50">E-mail</dt>
                        <dd><a href="mailto:info@revichillin.sk" class="link-accent">info@revichillin.sk</a></dd>
                    </div>
                    <div>
                        <dt class="text-white/50">Telefón</dt>
                        <dd><a href="tel:+421000000000" class="link-accent">+421 000 000 000</a></dd>
                    </div>
                    <div>
                        <dt class="text-white/50">Výdajné miesto</dt>
                        <dd>Chillová 42, 010 01 Žilina</dd>
                    </div>
                </dl>

                <h3 class="font-semibold mt-6 mb-2">Otváracie hodiny</h3>
                <table class="w-full text-sm">
                    @foreach ($openingHours as $days => $hours)
                        <tr class="border-b border-white/10 last:border-0">
                            <td class="py-2 text-white/70">{{ $days }}</td>
                            <td class="py-2 text-right">{{ $hours }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{-- Fakturačné údaje spoločnosti --}}
            <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-6">
                <h2 class="text-xl font-semibold mb-4">Fakturačné údaje</h2>

                {{-- dl/dt/dd = HTML zoznam dvojíc "názov – hodnota", presne na to určený --}}
                <dl class="space-y-3 text-sm">
                    @foreach ($company as $label => $value)
                        <div>
                            <dt class="text-white/50">{{ $label }}</dt>
                            <dd>{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </section>
@endsection
