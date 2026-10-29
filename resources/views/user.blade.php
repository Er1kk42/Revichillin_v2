@extends('layouts.app')

@section('content')
    <section class="max-w-4xl mx-auto px-4 pt-32 pb-20">
        <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-8 min-h-[400px]">
            <h1 class="text-2xl md:text-3xl font-semibold">Môj profil</h1>

            <nav class="flex flex-wrap justify-center gap-15 mt-6 pb-4 border-b border-white/10">
                <a href="#profile" data-tab="profile" class="menu-item user-tab">Profil</a>
                <a href="#orders" data-tab="orders" class="menu-item user-tab">História objednávok</a>
                <a href="#posts" data-tab="posts" class="menu-item user-tab">História príspevkov</a>
            </nav>

            <div id="tab-profile" class="user-panel mx-auto mt-8 max-w-md">
                @if (session('status'))
                    <p class="mb-4 rounded-lg border border-green-400/30 bg-green-400/10 px-4 py-2 text-sm text-green-300">
                        {{ session('status') }}
                    </p>
                @endif

                <form method="POST" action="{{ route('user.update') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm text-white/60 mb-1">Meno</label>
                        <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white focus:outline-none focus:border-orange-400/60">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="current_password" class="block text-sm text-white/60 mb-1">Staré heslo</label>
                        <input id="current_password" name="current_password" type="password" placeholder="Zadaj aktuálne heslo"
                               autocomplete="current-password"
                               class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white placeholder-white/30 focus:outline-none focus:border-orange-400/60">
                        @error('current_password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm text-white/60 mb-1">Nové heslo</label>
                        <input id="password" name="password" type="password" placeholder="Nechaj prázdne, ak ho nemeníš"
                               autocomplete="new-password"
                               class="w-full rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-white placeholder-white/30 focus:outline-none focus:border-orange-400/60">
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="block w-1/2 rounded-2xl mx-auto border border-white/40 py-2 text-sm font-medium uppercase tracking-wider hover:bg-white hover:text-black transition-colors duration-300">
                        Uložiť zmeny
                    </button>
                </form>
            </div>

            <div id="tab-orders" class="user-panel mt-8 hidden text-center">
                <p class="text-white/60">Zatiaľ nemáš žiadne objednávky.</p>
            </div>

            <div id="tab-posts" class="user-panel mt-8 hidden text-center">
                <p class="text-white/60">Zatiaľ nemáš žiadne príspevky.</p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.user-tab');
            const panels = document.querySelectorAll('.user-panel');

            const activate = (name) => {
                tabs.forEach(tab => tab.classList.toggle('text-orange-400', tab.dataset.tab === name));
                panels.forEach(panel => panel.classList.toggle('hidden', panel.id !== 'tab-' + name));
            };

            tabs.forEach(tab => tab.addEventListener('click', (e) => {
                e.preventDefault();
                activate(tab.dataset.tab);
                history.replaceState(null, '', '#' + tab.dataset.tab);
            }));

            const initial = location.hash.slice(1);
            activate(document.getElementById('tab-' + initial) ? initial : 'profile');
        });
    </script>
@endsection
