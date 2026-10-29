@extends('layouts.app')

@section('content')
    <section class="max-w-md mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Registrácia</h1>

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm text-white/85 mb-1">Meno</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60 focus:border">
            </div>

            <div>
                <label for="email" class="block text-sm text-white/85 mb-1">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="w-full rounded-lg border border-white/10 bg-blue-950/15 px-4 py-2 text-white focus:outline-none focus:ring-4 focus:ring-orange-400/80 transition duration-200">
            </div>
                        {{-- focus ring spravi okraj, farba/50 da priehladnost, TODO doladit farby v login a register... --}}
            <div>
                <label for="birth_date" class="block text-sm text-white/85 mb-1">Dátum narodenia</label>
                <input id="birth_date" name="birth_date" type="date" required
                       max="{{ now()->subYears(18)->toDateString() }}"
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
                @error('birth_date')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
                {{--@errors si pamataju vsetky errory z predosleho postu, ak sa medzi errormi najde 'birth_date' zavola sa message a vzpise sa --}}
            </div>

            <div>
                <label for="password" class="block text-sm text-white/85 mb-1">Heslo</label>
                <input id="password" name="password" type="password" required
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm text-white/85 mb-1">Potvrdenie hesla</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
            </div>

            <button type="submit"
                    class="w-full rounded-full border border-white/40 py-2 text-sm font-medium uppercase tracking-wider hover:bg-white hover:text-black transition-colors duration-300">
                Zaregistrovať sa
            </button>
        </form>

        <p class="text-white/60 text-sm mt-6">
            Máte už účet? <a href="/login" class="text-orange-400 hover:underline">Prihláste sa</a>
        </p>
    </section>
@endsection
