@extends('layouts.app')

@section('content')
    <section class="max-w-3xl mx-auto px-8 pt-32 pb-20 bg-black/72">
        <a href="{{ url('/products') }}" class="text-sm text-white/60 hover:text-orange-400 transition-colors duration-300">
            &larr; Späť na produkty
        </a>

        <h1 class="text-4xl font-bold mt-4 mb-2">{{ $product->name }}</h1>
        <div class="w-[25vw] min-w-64 mb-6 mx-auto">
            @if ($product->image)
                <img src="{{ asset('img/products/'.$product->image) }}" alt="{{ $product->name }}"
                     class="aspect-square w-full rounded-xl object-cover">
            @else
                <div class="aspect-square w-full rounded-xl bg-white/5 flex items-center justify-center text-white/30 text-sm">
                    Bez obrázka
                </div>
            @endif
            <div class="mt-4 flex items-center justify-between gap-3">
                <p class="text-2xl text-orange-400 font-semibold">{{ number_format((float) $product->price, 2) }} €</p>
                <button type="button" class="add-to-cart buttonsAll shrink-0" data-url="{{ route('cartAdd', $product->id) }}">Pridať do košíka</button>
            </div>
        </div>
        @if ($product->description)
            <p class="text-white/80 mb-6">{{ $product->description }}</p>

        @endif

        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <dt class="text-white/50 uppercase tracking-wider">Skladom</dt>
                <dd class="text-white mt-1">{{ $product->stock }} ks</dd>
            </div>
            @if (! is_null($product->nicotine_strength))
                <div>
                    <dt class="text-white/50 uppercase tracking-wider">Sila nikotínu</dt>
                    <dd class="text-white mt-1">{{ $product->nicotine_strength }} mg</dd>
                </div>
            @endif
        </dl>

        <h2 class="text-2xl font-bold mt-10 mb-4">Recenzie</h2>

        {{--forels je direktiva, ktora spaja foreach a isempty?--}}
        @forelse ($product->reviews as $review)
            <div class="mb-4">
                <p class="font-semibold">{{ $review->user->name }}</p>
                <p class="text-white/80">{{ $review->text }}</p>
                <div class="h-px w-full bg-white/50 my-6"></div>
            </div>
        @empty
            <p class="text-white/60">Žiadne recenzie zatiaľ nie sú.</p>
        @endforelse

        @auth
            <form method="POST" action="{{ route('reviewStore', $product) }}" class="mt-6">
                @csrf
                <textarea name="text" rows="3" required class="w-full p-2 rounded bg-white/5 border border-white/20">{{ old('text') }}</textarea>
                @error('text')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
                <button type="submit" class="buttonsAll mt-2">Pridať recenziu</button>
            </form>
        @endauth
    </section>
@endsection
