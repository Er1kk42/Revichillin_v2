<?php
//ciatocne upravene pomocou AI
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Košík je prázdny.');
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->quantity > $cartItem->product->stock) {
                return redirect()->route('cart')->with('error', 'Produkt '.$cartItem->product->name.' nie je na sklade v požadovanom množstve.');
            }
        }

        $order = DB::transaction(function () use ($user, $cartItems) {
            $order = $user->orders()->create([
                'order_number' => (Order::lockForUpdate()->max('order_number') ?? 0) + 1,
                'total_price' => $cartItems->sum('total'),
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            $user->cartItems()->delete();

            return $order;
        });

        return redirect()->route('user')->withFragment('orders')->with('status', 'Objednávka č. '.$order->order_number.' bola vytvorená.');
    }
}
