<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
//ciatocne upravene pomocou AI
class ProductController extends Controller
{
    public function index(Request $request)
    {
        $options = [
            'productType' => ProductType::orderBy('name')->get(),
            'flavors' => Flavor::orderBy('name')->get(),
            'brand' => Brand::orderBy('name')->get(),
        ];

        $maxima = [
            'nicotine_strength' => (int) Product::max('nicotine_strength'),
            'price' => (int) ceil((float) Product::max('price')),
        ];

        $query = Product::query();

        foreach (array_keys($options) as $relation) {
            $query->when($request->filled($relation), fn ($productQuery) => $productQuery->whereHas(
                $relation,
                fn ($relationQuery) => $relationQuery->whereIn('slug', (array) $request->input($relation))
            ));
        }

        foreach ($maxima as $column => $max) {
            $query->when($request->integer($column, $max) < $max,
                fn ($productQuery) => $productQuery->where($column, '<=', $request->integer($column)));
        }

        return view('products.index', [
            'products' => $query->get(),
            'options' => $options,
            'maxima' => $maxima,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('reviews.user');

        return view('products.show', ['product' => $product]);
    }
}
