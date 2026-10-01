@extends('layouts.app')

@section('content')
    <section class="max-w-3xl mx-auto px-8 pt-32 pb-20">
        <a href="{{ url('/products') }}" class="text-sm text-white/60 hover:text-orange-400 transition-colors duration-300">
            &larr; Späť na produkty
        </a>

        <h1 class="text-4xl font-bold mt-4 mb-2">{{ $product->name }}</h1>
        <p class="text-2xl text-orange-400 font-semibold mb-6">{{ number_format((float) $product->price, 2) }} €</p>

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
    </section>
@endsection
