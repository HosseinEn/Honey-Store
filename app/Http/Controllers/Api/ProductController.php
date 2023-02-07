<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with([
            'attributes' => function($query) {
                return $query->where('stock', '!=', 0);
            },
            'image', 
            'type'
        ])->isActive()->get();
        return new JsonResponse([
            'products' => $products
        ]);
    }

    public function show(Product $product) {
        if($product->status !== 1) {
            return abort(404);
        }
        $product->load([
            'attributes'  => function($query) {
                return $query->where('stock', '!=', 0);
            }, 
            'image'
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
