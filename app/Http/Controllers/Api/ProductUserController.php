<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductUserController extends Controller
{
    public function index() {
        $products = Auth::user()->products;
        $totalPrice = 0;
        foreach ($products as $product) {
            $attribute_id = $product->pivot->attribute_id;
            $quantity = $product->pivot->quantity;
            $price = $product->attributes->where('id', $attribute_id)->first()->pivot->price;
            $totalPrice += $price * $quantity;              
        }
        return new JsonResponse([
            'products' => $products,
            'totalPrice' => $totalPrice
        ]);
    }

    public function addToCart(AddToCartRequest $request, Product $product) {
        $user = Auth::user();

        $productAlreadyAddedToCart = DB::table('product_user')->where('attribute_id', $request->attribute_id)
                                                              ->where('product_id', $product->id)
                                                              ->where('user_id', $user->id)
                                                              ->exists();                                                    
        if($productAlreadyAddedToCart) {
            throw ValidationException::withMessages([
                'attribute_id' => ['محصول  با این وزن هم اکنون به کارت افزوده شد!']
            ]);
        }

        $user->products()->attach([
            $product->id => [
                'quantity' => $request->quantity, 
                'attribute_id' => $request->attribute_id
            ]
        ]);

        return new JsonResponse([
            'success' => 'محصول با موفقیت به کارت افزوده شد!' 
        ]);
    }
}
