{{--
    ============================================================================
    DOMOVSKÁ STRÁNKA
    ----------------------------------------------------------------------------
    @extends = stránka použije spoločnú kostru z resources/views/layouts/app.blade.php
    (hlavička, menu...). Sama definuje iba svoje časti cez @section.
    ============================================================================
--}}
@extends('layouts.app')


{{--
    HERO SEKCIA - vloží sa do @yield('hero') v layoute
--}}
@section('hero')

    {{-- relative = kotva pre absolútne umiestnené deti (video, overlay)
         h-screen w-full = presne výška a šírka obrazovky
         overflow-hidden = video, ktoré presahuje okraje, sa oreže --}}
    <section class="relative h-screen w-full overflow-hidden">

        {{-- VIDEO NA POZADÍ
             - autoplay = spustí sa samo
             - muted = bez zvuku (prehliadače dovolia autoplay IBA stlmeného videa)
             - loop = prehráva sa dookola
             - playsinline = na iPhone sa neotvorí na celú obrazovku
             - absolute inset-0 = roztiahne sa cez celú sekciu
             - object-cover = vyplní plochu bez deformácie (okraje sa orežú)
             asset('videos/hero.mp4') = URL súboru public/videos/hero.mp4 --}}
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
        </video>

        {{-- TMAVÝ OVERLAY - polopriehľadná čierna vrstva (40 %) nad videom,
             aby bol biely text dobre čitateľný aj na svetlých záberoch --}}
        <div class="absolute inset-0 bg-black/40"></div>

        {{-- OBSAH NAD VIDEOM
             - relative z-10 = je nad videom aj nad overlayom
             - flex flex-col items-center justify-center = text presne v strede
               (vodorovne aj zvisle), položky pod sebou
             - px-4 = odsadenie po stranách, aby text na mobile nebol na okraji --}}
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">

            {{-- text-5xl md:text-7xl = responzívna veľkosť:
                 na mobile 5xl, od šírky 768px (md) väčšie 7xl --}}
            <h1 class="text-5xl md:text-7xl font-bold mb-4">
                Cíť sa dobre.
            </h1>

            {{-- max-w-xl = obmedzená šírka odseku, aby riadky neboli
                 príliš dlhé (horšie sa čítajú) --}}
            <p class="text-lg md:text-xl text-white/80 max-w-xl">
                Objav naše nikotínové vrecká, e-cigarety a viac.
            </p>
        </div>
    </section>
@endsection


{{--
    HLAVNÝ OBSAH - vloží sa do @yield('content') (do elementu <main>) v layoute
--}}
@section('content')
    {{-- ostatný obsah domovskej stránky --}}
@endsection
