<!DOCTYPE html>
<html lang="sk">
<head>
    //ciatocne upravene pomocou AI
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revichillin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ route('login') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-neutral-950 bg-cover bg-center bg-no-repeat bg-fixed min-h-screen text-white"
      style="background-image: url('{{ asset('img/bckground-test.jpg') }}')">

<header class="fixed top-0 left-0 w-full z-50 bg-transparent backdrop-blur-sm">
    <nav class="flex items-center justify-between px-8 py-5">
        <a href="{{ route('welcome') }}" class="text-xl font-bold tracking-wide">
            REVICHILLIN
        </a>

        <div id="nav-wrapper" class="flex-1 min-w-0 flex items-center justify-center gap-14 mx-8">
            <ul id="nav-items" class="flex gap-14 text-sm font-medium uppercase tracking-wider">
                <li data-nav-item>
                    <a href="{{ route('welcome') }}" class="menu-item">
                        Domov
                    </a>
                </li>
                <li data-nav-item>
                    <a href="{{ route('products') }}" class="menu-item">
                        Produkty
                    </a>
                </li>
                <li data-nav-item>
                    <a href="{{ route('about') }}" class="menu-item">
                        O nás
                    </a>
                </li>
                <li data-nav-item>
                    <a href="{{ route('contacts') }}" class="menu-item">
                        Kontakt
                    </a>
                </li>
            </ul>

            <div class="relative shrink-0">
                <button id="nav-more-btn" type="button" class="hidden menu-item cursor-pointer">⋯</button>

                <ul id="nav-more-dropdown" class="hidden flex absolute right-0 top-full mt-2 bg-black/90 rounded-lg p-4 flex-col gap-3 text-sm font-medium uppercase tracking-wider whitespace-nowrap"></ul>
            </div>
        </div>

        <a href="{{ route('cart') }}" class="menu-item">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7 m-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>

        </a>

        @guest
        <a href="{{ route('login') }}"
           class="buttonsAll">
            Prihlásiť sa
        </a>
        @endguest
        @auth
            <a href="{{ route('user') }}" class="menu-item">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10">
                    <path d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </a>
        @endauth
    </nav>
</header>

@hasSection('hero')
    @yield('hero')
@endif

<main class="flex-1">
    @yield('content')
</main>

<div id="flash" hidden data-success="{{ session('status') }}"></div>

<div id="page-loader" class="hidden flex fixed inset-0 z-[100] items-center justify-center bg-black/38 backdrop-blur-xs">
    <div class="size-[60px] rounded-full border-6 border-orange-400 border-t-transparent animate-spin"></div>
</div>

<footer class="bg-neutral-900 text-white/70 px-8 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="text-white font-bold text-lg mb-3">REVICHILLIN</h3>
            <p class="text-sm">Tvoj e-shop s nikotínovými produktmi.</p>
        </div>

        <div>
            <h4>Navigácia</h4>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('welcome') }}" class="hover:text-orange-400 transition-colors">Domov</a></li>
                <li><a href="{{ route('products') }}" class="hover:text-orange-400 transition-colors">Produkty</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-orange-400 transition-colors">O nás</a></li>
                <li><a href="{{ route('contacts') }}" class="hover:text-orange-400 transition-colors">Kontakt</a></li>
            </ul>
        </div>

        <div>
            <h4>Info</h4>
            <p class="text-sm">Predaj len osobám nad 18 rokov.</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto border-t border-white/10 mt-8 pt-6 text-center text-xs">
        &copy; {{ date('Y') }} Revichillin. Všetky práva vyhradené.
    </div>
</footer>

</body>
</html>
