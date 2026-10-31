@extends('layouts.app')

@section('content')
    <section class="max-w-4xl mx-auto px-4 pt-32 pb-20">
        <div class="rounded-2xl border border-white/10 bg-black/70 backdrop-blur p-8 min-h-[400px]">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-semibold">Môj profil</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors duration-300">
                        Odhlásiť sa
                    </button>
                </form>
            </div>

            <nav class="flex flex-wrap justify-center gap-15 mt-6 pb-4 border-b border-white/10">
                <a href="#profile" data-tab="profile" class="menu-item user-tab">Profil</a>
                <a href="#orders" data-tab="orders" class="menu-item user-tab">História objednávok</a>
                <a href="#posts" data-tab="posts" class="menu-item user-tab">Moje recenzie</a>
            </nav>

            <div id="tab-profile" class="user-panel mx-auto mt-8 max-w-md">
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

            <div id="tab-orders" class="user-panel mt-8 hidden">
                @forelse ($orders as $order)
                    <div class="mb-4 rounded-xl border border-white/10 bg-white/5 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold">Objednávka č. {{ $order->order_number }}</h2>
                            <span class="text-sm text-white/60">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                        </div>

                        <ul class="mt-3 space-y-1 text-sm">
                            @foreach ($order->items as $orderItem)
                                <li class="flex justify-between">
                                    <span>{{ $orderItem->product->name }}</span>
                                    <span class="text-white/60">{{ $orderItem->quantity }} ks</span>
                                </li>
                            @endforeach
                        </ul>

                        <p class="mt-3 border-t border-white/10 pt-3 text-right">
                            Spolu: <strong>{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</strong>
                        </p>
                    </div>
                @empty
                    <p class="text-center text-white/60">Zatiaľ nemáš žiadne objednávky.</p>
                @endforelse
            </div>

            <div id="tab-posts" class="user-panel mt-8 hidden">
                @error('text', 'reviewUpdate')
                    <p class="mb-4 text-center text-red-400 text-sm">{{ $message }}</p>
                @enderror

                @forelse ($reviews as $review)
                    <div class="review-card mb-4 rounded-xl border border-white/10 bg-white/5 p-4">
                        <div class="flex items-center justify-between">
                            <a href="/products/{{ $review->product->id }}" class="font-semibold hover:text-orange-400 transition-colors">{{ $review->product->name }}</a>
                            <span class="text-sm text-white/60">{{ $review->created_at->format('d.m.Y H:i') }}</span>
                        </div>

                        <div class="review-view">
                            <p class="mt-3 text-white/80">{{ $review->text }}</p>

                            <div class="mt-3 flex justify-end gap-2">
                                <button type="button" class="review-edit-btn rounded-lg border border-white/40 px-4 py-1 text-sm hover:bg-white hover:text-black transition-colors duration-300">
                                    Upraviť
                                </button>

                                <form method="POST" action="{{ route('reviewDestroy', $review) }}" onsubmit="return confirm('Naozaj chceš zmazať túto recenziu?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-1 text-sm text-white hover:bg-red-700 transition-colors duration-300">
                                        Zmazať
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('reviewUpdate', $review) }}" class="review-edit mt-3 hidden">
                            @csrf
                            @method('PATCH')
                            <textarea name="text" rows="3" required maxlength="2000"
                                      class="w-full rounded-lg border border-white/10 bg-white/5 p-2 text-white focus:outline-none focus:border-orange-400/60">{{ $review->text }}</textarea>

                            <div class="mt-2 flex justify-end gap-2">
                                <button type="button" class="review-cancel-btn rounded-lg border border-white/40 px-4 py-1 text-sm hover:bg-white hover:text-black transition-colors duration-300">
                                    Zrušiť
                                </button>
                                <button type="submit" class="rounded-lg bg-orange-500 px-4 py-1 text-sm text-white hover:bg-orange-600 transition-colors duration-300">
                                    Uložiť
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <p class="text-center text-white/60">Zatiaľ nemáš žiadne recenzie.</p>
                @endforelse
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.user-tab').forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('.user-panel').forEach(p => p.classList.toggle('hidden', p.id !== 'tab-' + tab.dataset.tab));
                {{--dataset.tab berie to, co je napisane v clase ako data-....  ak p.id neni tab-dataset.tab tak sa prida hiddne, ak podmienka neplati, tak sa odoberie--}}
            });
        });

        document.querySelector(`.user-tab[data-tab="${location.hash.slice(1)}"]`)?.click();

        document.querySelectorAll('.review-card').forEach(card => {
            const view = card.querySelector('.review-view');
            const edit = card.querySelector('.review-edit');

            {{--ked pouzivatel stlaci edit tlacidlo, schova sa preview a ukaze sa vpisovacie okno--}}
            card.querySelector('.review-edit-btn').addEventListener('click', () => {
                view.classList.add('hidden');
                edit.classList.remove('hidden');
            });

            {{--ked stlaci zrusit, schova sa edit okno a zobreazi sa view--}}
            card.querySelector('.review-cancel-btn').addEventListener('click', () => {
                view.classList.remove('hidden');
                edit.classList.add('hidden');
            });

        });
    </script>
@endsection
