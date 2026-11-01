<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Product $product)
    {
        $validated = $request->validated();

        $hasPurchased = $request->user()
            ->orders()
            ->whereRelation('items', 'product_id', $product->id)
            ->exists();

        if (! $hasPurchased) {
            return back()
                ->withErrors(['text' => 'Recenziu môžeš pridať len k produktu, ktorý máš zakúpený.'])
                ->withInput();
        }

        $request->user()->reviews()->create([
            'product_id' => $product->id,
            'text' => $validated['text'],
        ]);

        return back()->with('status', 'Recenzia bola pridaná.');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        abort_unless($review->user()->is($request->user()), 403);
        $validated = $request->validated();
        $review->update(['text' => $validated['text']]);

        return redirect()->route('user')->withFragment('posts')->with('status', 'Recenzia bola upravená.');
    }

    public function destroy(Request $request, Review $review)
    {
        abort_unless($review->user()->is($request->user()), 403);
        $review->delete();

        return redirect()->route('user')->withFragment('posts')->with('status', 'Recenzia bola zmazaná.');
    }
}
