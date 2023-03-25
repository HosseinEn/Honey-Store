<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {
        $discounts = Discount::all();

        $products = Product::with([
            'attributes' => function($query) {
                return $query->where('stock', '!=', 0);
            },
            'image', 
            'type'
        ])->isActive()
          ->latest()
          ->get();
        return new JsonResponse([
            'products' => $products,
            'discounts' => $discounts,
        ]);
    }

    public function show(Product $product) {
        if($product->status != 1) {
            return abort(404);
        }
        $product->load([
            'attributes'  => function($query) {
                return $query->where('stock', '!=', 0);
            }, 
            'image',
            'type'
        ]);
        $minPrice = $product->attributes->min('attribute_product.price');
        $maxPrice = $product->attributes->max('attribute_product.price');
        return new JsonResponse([
            'product' => $product,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ]);
    }
}
