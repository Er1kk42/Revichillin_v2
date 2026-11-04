@extends('layouts.app')
@section('content')
    <section class="page-section">
        <h1 class="mb-4">Doprava a platba</h1>

        <div class="mt-12 card p-6">
            <h2 class="text-xl font-semibold mb-3">Spôsoby dopravy</h2>
            <ul class="descriptions mb-6 space-y-2">
                <li>Packeta – výdajné miesto alebo Z-BOX: <span class="price">2,90 €</span></li>
                <li>Kuriér DPD – doručenie na adresu: <span class="price">4,50 €</span></li>
                <li>Slovenská pošta – balík na poštu: <span class="price">3,90 €</span></li>
                <li>Pri objednávke nad 40 € je doprava <span class="price">zadarmo</span>.</li>
            </ul>

            <h2 class="text-xl font-semibold mb-3">Spôsoby platby</h2>
            <ul class="descriptions mb-6 space-y-2">
                <li>Platobná karta online (Visa, Mastercard, Apple Pay, Google Pay): <span class="price">zadarmo</span></li>
                <li>Bankový prevod: <span class="price">zadarmo</span></li>
                <li>Dobierka: <span class="price">1,50 €</span></li>
            </ul>

            <h2 class="text-xl font-semibold mb-3">Dodacia lehota</h2>
            <p class="descriptions mb-6">
                Objednávky prijaté v pracovný deň do 14:00 odosielame ešte v ten istý deň.
                Doručenie zvyčajne trvá 1 – 2 pracovné dni. O odoslaní zásielky vás budeme
                informovať e-mailom spolu s číslom na sledovanie zásielky.
            </p>

            <h2 class="text-xl font-semibold mb-3">Overenie veku pri prevzatí</h2>
            <p class="descriptions">
                Keďže predávame produkty s obsahom nikotínu, dopravca môže pri prevzatí zásielky
                požiadať o preukázanie totožnosti. Zásielku osobe mladšej ako 18 rokov neodovzdá.
            </p>
        </div>
    </section>
@endsection
