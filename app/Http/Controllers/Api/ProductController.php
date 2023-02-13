<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        // DB::enableQueryLog();
        $productsQuery = Product::with([
            'attributes' => function($query) {
                return $query->where('stock', '!=', 0);
            },
            'image', 
            'type'
        ])->isActive();
        $counts = $productsQuery->count();
        $products = $productsQuery->paginate(10);
        // dd(DB::getQueryLog());
        return new JsonResponse([
            'products' => $products,
            'productsLength' => $counts
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
