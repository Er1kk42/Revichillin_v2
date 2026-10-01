@extends('layouts.app')

@section('content')
    <section class="max-w-md mx-auto px-8 pt-32 pb-20">
        <h1 class="text-4xl font-bold mb-8">Prihlásenie</h1>

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm text-white/60 mb-1">E-mail</label>
                <input id="email" name="email" type="email" required autofocus
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
            </div>

            <div>
                <label for="password" class="block text-sm text-white/60 mb-1">Heslo</label>
                <input id="password" name="password" type="password" required
                       class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
            </div>

            <button type="submit"
                    class="w-full rounded-full border border-white/40 py-2 text-sm font-medium uppercase tracking-wider hover:bg-white hover:text-black transition-colors duration-300">
                Prihlásiť sa
            </button>
        </form>

        <p class="text-white/60 text-sm mt-6">
            Nemáte účet? <a href="/register" class="text-orange-400 hover:underline">Zaregistrujte sa</a>
        </p>
    </section>
@endsection
