<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class ProductUserController extends Controller
{
    public function index() {
        // dump(Auth::user()->products);
        $products = Auth::user()->products;
        $totalPrice = $this->calculatePrice();
        return new JsonResponse([
            'products' => $products,
            'totalPrice' => $totalPrice
        ]);
    }

    private function calculatePrice() {
        // TODO tax and carrier price ignored
        $products = Auth::user()->products;
        $products->load('attributes');
        $totalPrice = 0;
        foreach ($products as $product) {
            $attribute_id = $product->pivot->attribute_id;
            $quantity = $product->pivot->quantity;
            $price = $product->attributes->where('id', $attribute_id)->first()->pivot->price;
            $totalPrice += $price * $quantity;              
        }
        return $totalPrice;
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

    /* NOT COMPLETEEEEEEEEEEEED AND NOT TESTED */
    public function checkoutCart(Request $request, User $user) {

        if($user->products->isEmpty()) {
            throw ValidationException::withMessages([
                'message' => ['سبد خرید خالی است']
            ]);
        }
        else {
            // TODO tax and carrier ignored
            // dump($user->id);
            // $user = Auth::user();
            // dump($user);
            $order_status = OrderStatus::where('name', 'در انتظار تایید اپراتور')->first();
            // dump("status ok");

            $order = Order::create([
                'user_id' => $user->id,
                'order_status_id' => $order_status->id,
                // 'carrier_id' => ,
                // 'tax_id' => ,
                'discount_id' => isset($request->discount_id) ? $request->discount_id : null,
                'delivery_date' => null,
                'total_price' => $this->calculatePrice(),
                // 'total_weight' => 
                'invoice_no' => Str::random(20),
                'shipping_address' => $request->address,
                'billing_no' => Str::random(20)
            ]);

            $order->order_statuses()->attach([
                $order_status->id => [
                    'status_date' => $order_status->created_at,
                ]
            ]);
            
            $products = $user->products;

            foreach ($products as $product) {
                $order->products()->attach([
                    $product->id => [
                        'quantity' => $product->pivot->quantity,
                        'attribute_id' => $product->pivot->attribute_id
                    ]
                ]);
            }
            $user->products()->detach();

            return new JsonResponse([
                'order' => $order
            ]);
        }
    }

    public function updateCart(Request $request, User $user) {

        
        
    }

}
