<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
               $userId = auth()->id();
        $cartItems = CartItem::with('product')->where('user_id', $userId)->get(); //with('product') zavola sa metoda producty z CartItem

        $price = 0;
        foreach ($cartItems as $cartItem) {
            $price += $cartItem->product->price * $cartItem->quantity;
        }
        return view('cart.index', ['cartItems' => $cartItems, 'price' => $price]);
    }

    public function addToCart(Product $item) {
        $cartItem = CartItem::where('user_id', auth()->id())->where('product_id', $item->id)->first();
        $totalStock = $item->stock;
        if ($cartItem) {
            if($cartItem->quantity < $totalStock) {
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                return response()->json([
                    'message' => 'Viac kusov tohto produktu nie je na sklade.',
                ], 422);
            }
        } else {
            if($totalStock < 1) {
                return response()->json([
                    'message' => 'Viac kusov tohto produktu nie je na sklade.',
                ], 422);
            }
            //create, where, find, orderBy niesu v modeli priamo, laravel ich presmeruje cez php metodu __callStatic
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $item->id,
                'quantity' => 1,
            ]);
        }
        return response()->json([
            'message' => 'Produkt bol pridaný do košíka',
            ...$this->cartSummary($item),
        ]);
    }

    public function removeFromCart(Product $item) {
        $cartItem = CartItem::where('user_id', auth()->id())->where('product_id', $item->id)->firstOrFail();

        if ($cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return response()->json($this->cartSummary($item));
    }

    public function destroy(CartItem $item) {
        abort_if($item->user_id !== auth()->id(), 403);

        $product = $item->product;
        $item->delete();

        return response()->json($this->cartSummary($product));
    }

    private function cartSummary(Product $product): array {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        $quantity = $cartItems->firstWhere('product_id', $product->id)?->quantity ?? 0;

        return [
            'quantity'   => $quantity,
            'item_total' => $product->price * $quantity,
            'cart_total' => $cartItems->sum(fn ($cartItem) => $cartItem->product->price * $cartItem->quantity),
            'cart_count' => $cartItems->sum('quantity'),
        ];
    }
}
