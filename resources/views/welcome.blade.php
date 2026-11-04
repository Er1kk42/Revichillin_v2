@extends('layouts.app')

@section('hero')

    <section class="relative h-screen w-full overflow-hidden">
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <h1 class="text-5xl md:text-7xl font-bold">
                Cíťte sa dobre.
            </h1>
        </div>
    </section>
@endsection

@section('content')

    {{-- Slider s bannermi - zatiaľ prázdne, obsah sa doplní neskôr --}}
    <section class="w-full py-24">
        <div data-slider class="relative overflow-hidden">

            <div data-slider-track class="flex transition-transform duration-700 ease-in-out">
                <div data-slide class="w-full shrink-0 aspect-[3/1] bg-neutral-900/80 flex items-center justify-center">
                    <img src="{{ asset('img/slider1.png') }}" class="w-full h-full object-cover">
                </div>
                <div data-slide class="w-full shrink-0 aspect-[3/1] bg-neutral-800/80 flex items-center justify-center">
                    <img src="{{ asset('img/slider2.png') }}" class="w-full h-full object-cover">
                </div>
            </div>

        </div>

        {{-- Statický obrázok hneď pod sliderom - celá šírka, pevná výška 310 px --}}
        <img src="{{ asset('img/spodok.png') }}" class="block w-full h-[310px] object-cover">
    </section>
@endsection
