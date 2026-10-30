<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store()
    {
        $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Košík je prázdny.');
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()->route('cart')->with('error', 'Produkt '.$cartItem->product->name.' nie je na sklade v požadovanom množstve.');
            }
        }

        $order = DB::transaction(function () use ($cartItems) {
            $order = Order::create([
                'order_number' => (Order::lockForUpdate()->max('order_number') ?? 0) + 1,
                'user_id'      => auth()->id(),
                'total_price'  => $cartItems->sum(fn ($cartItem) => $cartItem->product->price * $cartItem->quantity),
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price,
                ]);
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            CartItem::where('user_id', auth()->id())->delete();

            return $order;
        });

        return redirect()->to(route('user').'#orders')->with('status', 'Objednávka č. '.$order->order_number.' bola vytvorená.');
    }
}
