@extends('layouts.app')
//ciatocne upravene pomocou AI
@section('content')
    <section class="page-section-narrow">
        <h1 class="mb-8">Registrácia</h1>

        <form method="POST" action="{{ route('registerSubmit') }}" class="space-y-4" data-validate>
            @csrf

            <div>
                <label for="name" class="form-label">Meno</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus maxlength="255"
                       class="form-input">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="255"
                       class="form-input">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="birth_date" class="form-label">Dátum narodenia</label>
                <input id="birth_date" name="birth_date" type="date" required
                       max="{{ now()->subYears(18)->toDateString() }}" data-min-age="18"
                       class="form-input">
                @error('birth_date')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Heslo</label>
                <input id="password" name="password" type="password" required minlength="8"
                       class="form-input">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Potvrdenie hesla</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required data-match="password"
                       class="form-input">
            </div>

            <button type="submit"
                    class="btn-form">
                Zaregistrovať sa
            </button>
        </form>

        <p class="text-white/60 text-sm mt-6">
            Už máš účet? <a href="{{ route('login') }}" class="link-accent">Prihlás sa</a>
        </p>
    </section>
@endsection
