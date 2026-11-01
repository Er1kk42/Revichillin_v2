{{-- Cena vo formáte 1 234,50 € – jediné miesto, kde sa formátuje cena na webe.
     Použitie: <x-price :value="$product->price" /> --}}
@props(['value'])
{{ number_format((float) $value, 2, ',', ' ') }} €
