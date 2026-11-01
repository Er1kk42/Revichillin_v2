<?php
//ciatocne upravene pomocou AI
namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();

        return view('cart.index', [
            'cartItems' => $cartItems,
            'price' => $cartItems->sum('total'),
        ]);
    }

    public function addToCart(Request $request, Product $item)
    {
        $cartItem = $request->user()->cartItems()->where('product_id', $item->id)->first();
        $totalStock = $item->stock;
        if ($cartItem) {
            if ($cartItem->quantity < $totalStock) {
                $cartItem->increment('quantity');
            } else {
                return response()->json([
                    'message' => 'Viac kusov tohto produktu nie je na sklade.',
                ], 422);
            }
        } else {
            if ($totalStock < 1) {
                return response()->json([
                    'message' => 'Viac kusov tohto produktu nie je na sklade.',
                ], 422);
            }
            $request->user()->cartItems()->create([
                'product_id' => $item->id,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Produkt bol pridaný do košíka',
            ...$this->cartSummary($request->user(), $item),
        ]);
    }

    public function removeFromCart(Request $request, Product $item)
    {
        $cartItem = $request->user()->cartItems()->where('product_id', $item->id)->firstOrFail();

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }

        return response()->json($this->cartSummary($request->user(), $item));
    }

    public function destroy(Request $request, CartItem $item)
    {
        abort_unless($item->user()->is($request->user()), 403);

        $product = $item->product;
        $item->delete();

        return response()->json($this->cartSummary($request->user(), $product));
    }

    private function cartSummary(User $user, Product $product): array
    {
        $cartItems = $user->cartItems()->with('product')->get();
        $cartItem = $cartItems->firstWhere('product_id', $product->id);

        return [
            'quantity' => $cartItem?->quantity ?? 0,
            'item_total' => $cartItem?->total ?? 0,
            'cart_total' => $cartItems->sum('total'),
            'cart_count' => $cartItems->sum('quantity'),
        ];
    }
}
