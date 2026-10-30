<?php

namespace App\Http\Controllers;

class CartController extends Controller
{
    public function index()
    {
        // TODO: načítať položky košíka prihláseného používateľa
        //       (auth()->user()->cartItems()->with('product')->get()), vypočítať celkovú sumu
        //       a poslať ich do view
        return view('cart.index');
    }

    // TODO: store(Request $request) – POST /cart (AJAX)
    //       - validovať product_id (exists:products,id) a quantity (integer, min:1)
    //       - ak produkt už v košíku je, zvýšiť quantity, inak vytvoriť nový CartItem
    //       - skontrolovať sklad (products.stock)
    //       - vrátiť JSON: { count } (počet položiek pre počítadlo v hlavičke)

    // TODO: update(Request $request, CartItem $item) – PATCH /cart/{item} (AJAX)
    //       - overiť, že $item patrí prihlásenému používateľovi (inak 403)
    //       - validovať quantity, skontrolovať sklad
    //       - vrátiť JSON: { itemTotal, cartTotal, count }

    // TODO: destroy(CartItem $item) – DELETE /cart/{item} (AJAX)
    //       - overiť, že $item patrí prihlásenému používateľovi (inak 403)
    //       - zmazať položku
    //       - vrátiť JSON: { cartTotal, count }
}
