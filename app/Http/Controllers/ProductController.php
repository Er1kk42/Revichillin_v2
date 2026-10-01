<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::all();  // ← toto komunikuje s databázou (cez Model)
        return view('products.index', ['products' => $products]);  // ← toto posiela výsledok do View
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', ['product' => $product]);
    }
}


