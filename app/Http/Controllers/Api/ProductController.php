<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::get();
        return new JsonResponse([
            'products' => $products
        ]);
    }

    public function show(Product $product) {
        $product->load('attributes', 'image');
        return new JsonResponse([
            'product' => $product
        ]);
    }
}
