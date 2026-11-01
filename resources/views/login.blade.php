@extends('layouts.app')

@section('content')
    <section class="page-section-narrow">
        <h1 class="mb-8">Prihlásenie</h1>

        <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="form-label">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="form-input">
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Heslo</label>
                <input id="password" name="password" type="password" required
                       class="form-input">
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="btn-form">
                Prihlásiť sa
            </button>
        </form>

        <p class="text-white/60 text-sm mt-6">
            Nemáte účet? <a href="/register" class="link-accent">Zaregistrujte sa</a>
        </p>
    </section>
@endsection
