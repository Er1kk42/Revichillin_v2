@extends('layouts.app')

@section('content')
    <section class="page-section">
        <h1 class="mb-8">Košík</h1>

        @if (session('error'))
            <p class="mb-6 rounded-lg border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm text-red-300">
                {{ session('error') }}
            </p>
        @endif

        <ul id="cart-list" class="flex flex-col gap-4">
            @forelse ($cartItems as $cartItem)
                <li class="card flex items-center gap-4" data-cart-item>
                    @if ($cartItem->product->image)
                        <img src="{{ $cartItem->product->image_url }}" alt="{{ $cartItem->product->name }}"
                             class="w-20 h-20 rounded-lg object-cover">
                    @endif

                    <div class="flex-1">
                        <h2 class="font-semibold">{{ $cartItem->product->name }}</h2>
                        <p class="text-sm text-white/60"><x-price :value="$cartItem->product->price" /> / ks</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" class="buttonsAll" data-url="{{ route('cartRemove', $cartItem->product->id) }}">−</button>
                        <span class="w-8 text-center" data-cart-quantity>{{ $cartItem->quantity }}</span>
                        <button type="button" class="buttonsAll" data-url="{{ route('cartAdd', $cartItem->product->id) }}">+</button>
                    </div>

                    <span class="w-24 text-right font-bold" data-cart-item-total><x-price :value="$cartItem->total" /></span>

                    <button type="button" class="btn-danger" data-url="{{ route('cartDestroy', $cartItem->id) }}" data-method="DELETE">Odstrániť</button>
                </li>
            @empty
                <li class="text-white/60">Tvoj košík je prázdny.</li>
            @endforelse
        </ul>

        <div id="cart-empty" class="{{ $cartItems->isEmpty() ? '' : 'hidden' }} mt-6">
            <a href="{{ route('products') }}" class="buttonsAll">Pokračovať v nákupe</a>
        </div>

        @if ($cartItems->isNotEmpty())
            <div id="cart-summary" class="mt-8 flex items-center justify-between">
                <span class="text-xl">Spolu: <strong id="cart-total"><x-price :value="$price" /></strong></span>
                <div class="flex items-center gap-4">
                    <button type="button" class="buttonsAll">Pokračovať k objednávke</button>
                    <form method="POST" action="{{ route('orderStore') }}">
                        @csrf
                        <button type="submit" class="btn-buy">Vytvoriť objednávku</button>
                    </form>
                </div>
            </div>
        @endif
    </section>
@endsection
