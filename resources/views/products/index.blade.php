@extends('layouts.app')

@section('content')
    <section class="page-section">
        <h1 class="mb-8">Produkty</h1>

        <form id="filters" method="GET" action="{{ route('products') }}">
            <nav class="flex flex-wrap justify-center gap-15 pb-4 border-b border-white/10">
                <button type="button" data-filter="productType" class="btn-filter">Typ</button>
                <button type="button" data-filter="flavors" class="btn-filter">Príchuť</button>
                <button type="button" data-filter="nicotine_strength" class="btn-filter">Sila</button>
                <button type="button" data-filter="brand" class="btn-filter">Značka</button>
                <button type="button" data-filter="price" class="btn-filter">Cena</button>
            </nav>

            @foreach ($options as $filter => $items)
                <div data-filter-panel="{{ $filter }}" class="filter-panel hidden">
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
                <div data-filter-panel="{{ $filter }}" class="filter-panel hidden">
                    <label class="flex items-center gap-3">
                        {{ $label }}
                        <input type="range" name="{{ $filter }}" min="0" max="{{ $maxima[$filter] }}"
                               value="{{ request($filter, $maxima[$filter]) }}"
                               class="accent-orange-400 cursor-pointer">
                        <output>{{ request($filter, $maxima[$filter]) }}</output>
                    </label>
                </div>
            @endforeach
        </form>

        <ul id="product-list" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-10">
            @forelse ($products as $product)
                <li class="card product-card">
                    <a href="{{ route('productShow', $product->id) }}" class="block">
                        @if ($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="product-image">
                        @else
                            <div class="product-image-empty">
                                Bez obrázka
                            </div>
                        @endif
                    </a>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="price text-xl"><x-price :value="$product->price" /></span>
                        <button type="button" class="btn-buy shrink-0" data-cart-add data-url="{{ route('cartAdd', $product->id) }}">Pridať do košíka</button>
                    </div>
                    <a href="{{ route('productShow', $product->id) }}">
                        <h2 class="mt-3 text-lg font-semibold hover:text-orange-400 transition-colors">{{ $product->name }}</h2>
                    </a>
                    <p class="descriptions mt-1 text-sm line-clamp-2">{{ $product->description }}</p>
                </li>
            @empty
                <li class="text-white/60">Žiadne produkty na zobrazenie.</li>
            @endforelse
        </ul>
    </section>
@endsection
