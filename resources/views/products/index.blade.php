@extends('layouts.app')

@section('content')
    <section class="max-w-5xl mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Produkty</h1>

        <form id="filters" method="GET" action="{{ url('/products') }}">
            <nav class="flex flex-wrap justify-center gap-15 pb-4 border-b border-white/10">
                <button type="button" data-filter="productType" class="buttonsAll filter-tab">Typ</button>
                <button type="button" data-filter="flavors" class="buttonsAll filter-tab">Príchuť</button>
                <button type="button" data-filter="nicotine_strength" class="buttonsAll filter-tab">Sila</button>
                <button type="button" data-filter="brand" class="buttonsAll filter-tab">Značka</button>
                <button type="button" data-filter="price" class="buttonsAll filter-tab">Cena</button>
            </nav>

            @foreach ($options as $filter => $items)
                <div id="filter-{{ $filter }}" class="filter-panel hidden">
                    @foreach ($items as $item)
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="{{ $filter }}[]" value="{{ $item->slug }}" class="accent-orange-400"
                                   @checked(in_array($item->slug, (array) request($filter)))>
                            {{ $item->name }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            @foreach (['nicotine_strength' => 'Max. sila (mg)', 'price' => 'Max. cena (€)'] as $filter => $label)
                <div id="filter-{{ $filter }}" class="filter-panel hidden">
                    <label class="flex items-center gap-3">
                        {{ $label }}
                        <input type="range" name="{{ $filter }}" min="0" max="{{ $maxima[$filter] }}"
                               value="{{ request($filter, $maxima[$filter]) }}"
                               oninput="this.nextElementSibling.value = this.value"
                               class="accent-orange-400 cursor-pointer">
                        <output>{{ request($filter, $maxima[$filter]) }}</output>
                    </label>
                </div>
            @endforeach
        </form>

        <ul id="product-list" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-10">
            @forelse ($products as $product)
                <li class="product-card">
                    <a href="{{ url('/products/'.$product->id) }}" class="block">
                        @if ($product->image)
                            <img src="{{ asset('img/products/'.$product->image) }}" alt="{{ $product->name }}"
                                 class="aspect-square w-full rounded-xl object-cover">
                        @else
                            <div class="aspect-square w-full rounded-xl bg-white/5 flex items-center justify-center text-white/30 text-sm">
                                Bez obrázka
                            </div>
                        @endif

                        <h2 class="mt-4 text-lg font-semibold hover:text-orange-400 transition-colors">{{ $product->name }}</h2>
                    </a>
                    <p class="mt-1 text-sm text-white/60 line-clamp-2">{{ $product->description }}</p>
                    <div class="mt-auto pt-4 flex items-center justify-between">
                        <span class="text-xl font-bold">{{ number_format((float) $product->price, 2, ',', ' ') }} €</span>
                        <button type="button" class="add-to-cart buttonsAll" data-url="{{ route('cartAdd', $product->id) }}">Pridať do košíka</button>
                    </div>
                </li>
            @empty
                <li class="text-white/60">Žiadne produkty na zobrazenie.</li>
            @endforelse
        </ul>
    </section>

    <script>

        {{-- Zoberie vsetky filter-tab, prida im event listener Click, zoberie vsetky panely a skontroluje ci sa ich id zhoduje s datafiltrom, ak nie, schova ich--}}
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.filter-panel').forEach(p => {
                    p.classList.toggle('hidden', p.id !== 'filter-' + tab.dataset.filter || !p.classList.contains('hidden'));
                });
            });
        });

        const filters = document.getElementById('filters');

        {{-- Pri dokoncenej zmene vo formulary sa zavola funkcia async(podporuje await) posklada sa nova url s filtrami, posle ju na server, zoberie si novy zoznam produktov, a nahradi stary --}}
        filters.addEventListener('change', async () => {
            const url = filters.action + '?' + new URLSearchParams(new FormData(filters)); //Formdata zbiera data z formularov URLSearchParams prevedie tieto data na text pre URL
            const html = await (await fetch(url)).text();
            const newList = new DOMParser().parseFromString(html, 'text/html').getElementById('product-list'); //DomParser() - nastroj na spracovanie dokumentov, parsefromString, zmen string na html, zoznam produktov

            document.getElementById('product-list').innerHTML = newList.innerHTML;
            history.replaceState(null, '', url);
        });
    </script>
@endsection
