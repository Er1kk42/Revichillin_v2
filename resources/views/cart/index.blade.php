@extends('layouts.app')

@section('content')
    <section class="max-w-5xl mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Košík</h1>

        @if (session('error'))
            <p class="mb-6 rounded-lg border border-red-400/30 bg-red-400/10 px-4 py-2 text-sm text-red-300">
                {{ session('error') }}
            </p>
        @endif

        <ul id="cart-list" class="flex flex-col gap-4">
            @forelse ($cartItems as $cartItem)
                <li class="cart-item flex items-center gap-4 rounded-xl bg-white/5 p-4" data-product-id="{{ $cartItem->product->id }}" data-item-id="{{ $cartItem->id }}">
                    @if ($cartItem->product->image)
                        <img src="{{ asset('img/products/'.$cartItem->product->image) }}" alt="{{ $cartItem->product->name }}"
                             class="w-20 h-20 rounded-lg object-cover">
                    @endif

                    <div class="flex-1">
                        <h2 class="font-semibold">{{ $cartItem->product->name }}</h2>
                        <p class="text-sm text-white/60">{{ number_format((float) $cartItem->product->price, 2, ',', ' ') }} € / ks</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" class="cart-minus buttonsAll">−</button>
                        <span class="cart-quantity w-8 text-center">{{ $cartItem->quantity }}</span>
                        <button type="button" class="cart-plus buttonsAll">+</button>
                    </div>

                    <span class="cart-item-total w-24 text-right font-bold">{{ number_format($cartItem->product->price * $cartItem->quantity, 2, ',', ' ') }} €</span>

                    <button type="button" class="cart-remove text-white/60 hover:text-red-400">Odstrániť</button>
                </li>
            @empty
                <li class="text-white/60">Tvoj košík je prázdny.</li>
            @endforelse
        </ul>

        <div id="cart-empty" class="{{ $cartItems->isEmpty() ? '' : 'hidden' }} mt-6">
            <a href="{{ url('/products') }}" class="buttonsAll">Pokračovať v nákupe</a>
        </div>

        @if ($cartItems->isNotEmpty())
            <div id="cart-summary" class="mt-8 flex items-center justify-between">
                <span class="text-xl">Spolu: <strong id="cart-total">{{ number_format($price, 2, ',', ' ') }} €</strong></span>
                <div class="flex items-center gap-4">
                    <button type="button" class="buttonsAll">Pokračovať k objednávke</button>
                    <form method="POST" action="{{ route('orderStore') }}">
                        @csrf
                        <button type="submit" class="buttonsAll">Vytvoriť objednávku</button>
                    </form>
                </div>
            </div>
        @endif
    </section>
@endsection
