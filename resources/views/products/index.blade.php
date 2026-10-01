@extends('layouts.app')

@section('content')
    <section class="max-w-5xl mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Produkty</h1>

        <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($products as $product)
                <li>
                    <a href="{{ url('/products/'.$product->id) }}"
                       class="block rounded-2xl border border-white/10 bg-white/5 p-5 hover:border-orange-400/60 hover:bg-white/10 transition-colors duration-300">
                        <span class="block text-lg font-semibold">{{ $product->name }}</span>
                        <span class="block text-white/60 mt-1">{{ number_format((float) $product->price, 2) }} €</span>
                    </a>
                </li>
            @empty
                <li class="text-white/60">Žiadne produkty na zobrazenie.</li>
            @endforelse
        </ul>
    </section>
@endsection
