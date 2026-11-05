@extends('layouts.app')

@section('content')
    <section class="max-w-4xl mx-auto px-4 pt-32 pb-20">
        <div class="card p-8 min-h-[400px]">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl md:text-3xl font-semibold">Môj profil</h1>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="btn-danger">
                        Odhlásiť sa
                    </button>
                </form>
            </div>

            <nav class="flex flex-wrap justify-center gap-15 mt-6 pb-4 border-b border-white/10">
                <a href="#profile" data-tab="profile" class="menu-item">Profil</a>
                <a href="#orders" data-tab="orders" class="menu-item">História objednávok</a>
                <a href="#posts" data-tab="posts" class="menu-item">Moje recenzie</a>
            </nav>

            <div data-tab-panel="profile" class="mx-auto mt-8 max-w-md">
                <form method="POST" action="{{ route('userUpdate') }}" class="space-y-4" data-validate>
                    @csrf

                    <div>
                        <label for="name" class="form-label">Meno</label>
                        <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required maxlength="255"
                               class="form-input">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="current_password" class="form-label">Staré heslo</label>
                        <input id="current_password" name="current_password" type="password" placeholder="Zadaj aktuálne heslo"
                               autocomplete="current-password" data-required-with="password"
                               class="form-input">
                        @error('current_password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label">Nové heslo</label>
                        <input id="password" name="password" type="password" placeholder="Nechaj prázdne, ak ho nemeníš"
                               autocomplete="new-password" minlength="8"
                               class="form-input">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="btn-form w-1/2 mx-auto">
                        Uložiť zmeny
                    </button>
                </form>
            </div>

            <div data-tab-panel="orders" class="mt-8 hidden">
                @forelse ($orders as $order)
                    <div class="card mb-4">
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
                            Spolu: <strong><x-price :value="$order->total_price" /></strong>
                        </p>
                    </div>
                @empty
                    <p class="text-center text-white/60">Zatiaľ nemáš žiadne objednávky.</p>
                @endforelse
            </div>

            <div data-tab-panel="posts" class="mt-8 hidden">
                @error('text', 'reviewUpdate')
                    <p class="mb-4 text-center text-red-400 text-sm">{{ $message }}</p>
                @enderror

                @forelse ($reviews as $review)
                    <div class="card mb-4" data-review>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('productShow', $review->product->id) }}" class="font-semibold hover:text-orange-400 transition-colors">{{ $review->product->name }}</a>
                            <span class="text-sm text-white/60">{{ $review->created_at->format('d.m.Y H:i') }}</span>
                        </div>

                        <div data-review-view>
                            <p class="mt-3 text-white/80">{{ $review->text }}</p>

                            <div class="mt-3 flex justify-end gap-2">
                                <button type="button" data-review-edit-btn class="rounded-lg border border-white/40 px-4 py-1 text-sm hover:bg-white hover:text-black transition-colors duration-300">
                                    Upraviť
                                </button>

                                <form method="POST" action="{{ route('reviewDestroy', $review) }}" data-confirm="Naozaj chceš zmazať túto recenziu?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger py-1">
                                        Zmazať
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('reviewUpdate', $review) }}" class="mt-3 hidden" data-review-edit data-validate>
                            @csrf
                            @method('PATCH')
                            <textarea name="text" rows="3" required maxlength="2000"
                                      class="form-input">{{ $review->text }}</textarea>

                            <div class="mt-2 flex justify-end gap-2">
                                <button type="button" data-review-cancel-btn class="rounded-lg border border-white/40 px-4 py-1 text-sm hover:bg-white hover:text-black transition-colors duration-300">
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
@endsection
