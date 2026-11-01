@extends('layouts.app')

@section('content')
    <section class="page-section-narrow">
        <h1 class="mb-8">Registrácia</h1>

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="form-label">Meno</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       class="form-input">
            </div>

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="form-input">
            </div>
            <div>
                <label for="birth_date" class="form-label">Dátum narodenia</label>
                <input id="birth_date" name="birth_date" type="date" required
                       max="{{ now()->subYears(18)->toDateString() }}"
                       class="form-input">
                @error('birth_date')
                <p class="form-error">{{ $message }}</p>
                @enderror
                {{--@errors si pamataju vsetky errory z predosleho postu, ak sa medzi errormi najde 'birth_date' zavola sa message a vzpise sa --}}
            </div>

            <div>
                <label for="password" class="form-label">Heslo</label>
                <input id="password" name="password" type="password" required
                       class="form-input">
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Potvrdenie hesla</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="form-input">
            </div>

            <button type="submit"
                    class="btn-form">
                Zaregistrovať sa
            </button>
        </form>

        <p class="text-white/60 text-sm mt-6">
            Máte už účet? <a href="/login" class="link-accent">Prihláste sa</a>
        </p>
    </section>
@endsection
