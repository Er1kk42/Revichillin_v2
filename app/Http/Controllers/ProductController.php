<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();  // ← toto komunikuje s databázou (cez Model)
        return view('products.index', ['products' => $products]);  // ← toto posiela výsledok do View
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', ['product' => $product]);
    }
}


