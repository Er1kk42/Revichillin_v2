{{--
    ============================================================================
    DOMOVSKÁ STRÁNKA
    ----------------------------------------------------------------------------
    @extends = stránka použije spoločnú kostru z resources/views/layouts/app.blade.php
    (hlavička, menu...). Sama definuje iba svoje časti cez @section.
    ============================================================================
--}}
@extends('layouts.app')



@section('hero')

    {{-- relative = kotva pre absolútne umiestnené deti (video, overlay)
         h-screen w-full = presne výška a šírka obrazovky
         overflow-hidden = video, ktoré presahuje okraje, sa oreže --}}
    <section class="relative h-screen w-full overflow-hidden">
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
