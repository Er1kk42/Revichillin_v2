<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'text' => ['required', 'string', 'max:2000'],
        ]);

        //request/auth -> getne prihlaseneho usera() z neho vezmeme orders() a z nich itemy, kore maju rovnake id ak $product
        //vezmi itemy objednavok prihlaseneho, ktore maju id ako z id z requestu a povedz, ci existuje aspon 1
        $hasPurchased = $request->user()
            ->orders()
            ->whereRelation('items', 'product_id', $product->id)
            //->whereHas('items', fn ($query) => $query->where('product_id', $product->id))
            ->exists();

        if (! $hasPurchased) {
            return back()
                ->withErrors(['text' => 'Tento produkt ste nezakúpili.'])
                ->withInput();
        }

        $product->reviews()->create([
            'user_id' => $request->user()->id,
            'text' => $validated['text'],
        ]);

        return back()->with('status', 'Recenzia bola pridaná.');
    }

    public function update(Request $request, Review $review)
    {
        abort_unless($review->user()->is($request->user()), 403);

        $validated = $request->validateWithBag('reviewUpdate', [
            'text' => ['required', 'string', 'max:2000'],
        ]);

        $review->update(['text' => $validated['text']]);

        return redirect()->to(route('user').'#posts')->with('status', 'Recenzia bola upravená.');
    }

    public function destroy(Request $request, Review $review)
    {
        abort_unless($review->user()->is($request->user()), 403);

        $review->delete();

        return redirect()->to(route('user').'#posts')->with('status', 'Recenzia bola zmazaná.');
    }
}
