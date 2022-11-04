<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Discount;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddToCartRequest;
use Illuminate\Validation\ValidationException;

class ProductUserController extends Controller
{
    public function index() {
        $products = Auth::user()->products;
        list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice();
        // $totalPrice = $this->calculatePrice();
        // $totalPriceWithDiscount = $this->calculatePrice();
        return new JsonResponse([
            'products' => $products,
            'totalPrice' => $totalPrice,
            'totalPriceWithDiscount' => $totalPriceWithDiscount
        ]);
    }

    public function increaseAmount(Request $request) {
        $request->validate([
            'product_user_id' => 'required'
        ]);
        $pivotRec = DB::table('product_user')->where('id', $request->product_user_id)->first();
        if (empty($pivotRec)) {
            throw ValidationException::withMessages([
                'product_user_id' => ['محصولی با مشخصات داده شده یافت نشد!']
            ]);
        }
        $quantity = $pivotRec->quantity + 1;
        $product = Product::findOrFail($pivotRec->product_id);
        $stock = $product->attributes->where('id', $pivotRec->attribute_id)->first()->attribute_product->stock;
        if ($stock < $quantity) {
            throw ValidationException::withMessages([
                'product_user_id' => ['امکان افزودن به کارت بیشتر از موجودی محصول امکان پذیر نمی باشد. موجودی: !' . $stock]
            ]);
        }
        DB::update('update product_user set quantity = ? where id = ?', [
            $quantity,
            $request->product_user_id
        ]);
        return DB::table('product_user')->where('id', $request->product_user_id)->get();
    }

    public function decreaseAmount(Request $request) {
        $request->validate([
            'product_user_id' => 'required'
        ]);
        $pivotRec = DB::table('product_user')->where('id', $request->product_user_id)->get();
        if ($pivotRec->isEmpty()) {
            throw ValidationException::withMessages([
                'product_user_id' => ['محصولی با مشخصات داده شده یافت نشد!']
            ]);
        }
        $quantity = $pivotRec->first()->quantity - 1;
        if ($quantity === 0) {
            throw ValidationException::withMessages([
                'product_user_id' => ['نمی توان تعداد را به صفر کاهش داد، لطفا در صورت تمایل محصول را از کارت حذف نمایید!']
            ]);
        }
        DB::update('update product_user set quantity = ? where id = ?', [
            $quantity,
            $request->product_user_id
        ]);
        return DB::table('product_user')->where('id', $request->product_user_id)->get();
    }

    private function calculatePrice() {
        // TODO tax and carrier price ignored
        $products = Auth::user()->products;
        $products->load('attributes');
        $totalPrice = 0;
        $totalPriceAfterDiscount = 0;
        foreach ($products as $product) {
            $attribute_id = $product->cart->attribute_id;
            $quantity = $product->cart->quantity;
            $price = $product->attributes->where('id', $attribute_id)->first()->attribute_product->price;
            $discount_id = $product->attributes->where('id', $attribute_id)->first()->attribute_product->discount_id;
            $totalPrice += $price * $quantity;         
            
            if ($discount_id){
                $dis_val = Discount::findOrFail($discount_id)->value;
                $totalDiscount = $price * $quantity * $dis_val / 100;         
                $totalPriceAfterDiscount = $totalPrice - $totalDiscount; 
            }
            else{
                $totalPriceAfterDiscount = $totalPrice; 
            }
        }
        return [$totalPrice, $totalPriceAfterDiscount];
    }

    public function addToCart(AddToCartRequest $request, Product $product) {
        $user = Auth::user();

        $productAlreadyAddedToCart = DB::table('product_user')->where('attribute_id', $request->attribute_id)
                                                              ->where('product_id', $product->id)
                                                              ->where('user_id', $user->id)
                                                              ->exists();                                                    
        if($productAlreadyAddedToCart) {
            throw ValidationException::withMessages([
                'attribute_id' => ['محصول  با این وزن از قبل به کارت افزوده شده است!']
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


    public function checkoutCart(Request $request) {
        $user = Auth::user();
        if($user->products->isEmpty()) {
            throw ValidationException::withMessages([
                'message' => ['سبد خرید خالی است']
            ]);
        }
        else {

            /* checking if given quantity is available in stock */

            $products = $user->products;

            $products->load('attributes');

   
            foreach ($products as $product) {
                $selectedAttribute = $product->attributes->where('id', $product->cart->attribute_id)->first();
                if ($selectedAttribute->attribute_product->stock < $product->cart->quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => ['لطفا با توجه به تعداد سفارش را انجام دهید. تعداد موجود: ' . $selectedAttribute->attribute_product->stock
                        . ' محصول: ' . $product->name . ' وزن:' . $selectedAttribute->weight]
                    ]);
                }
                else {
                    $product->update(["stock" => $product->stock - $product->cart->quantity]);

                    DB::update('update attribute_product set stock = ? where attribute_id = ? and product_id = ?', [
                        
                        $selectedAttribute->attribute_product->stock -= $product->cart->quantity,
                        $product->cart->attribute_id,
                        $product->id
                    ]);
                }
            }



            /* sending request to bank */


            /* create order */

            // TODO tax and carrier ignored
            $order_status = OrderStatus::where('name', 'در انتظار تایید اپراتور')->first();
            // dump("status ok");
            list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice();

            $order = Order::create([
                'user_id' => $user->id,
                'order_status_id' => $order_status->id,
                // 'carrier_id' => ,
                // 'tax_id' => ,
                'discount_id' => isset($request->discount_id) ? $request->discount_id : null,
                'delivery_date' => null,
                'total_price' => $totalPrice,
                // 'total_weight' => 
                'invoice_no' => Str::random(20),
                'shipping_address' => $request->address,
                'billing_no' => Str::random(20)
            ]);

            // static status_date
            $order->order_statuses()->attach([
                $order_status->id => [
                    'status_date' => now(),
                ]
            ]);

            foreach ($products as $product) {
                $order->products()->attach([
                    $product->id => [
                        'quantity' => $product->cart->quantity,
                        'attribute_id' => $product->cart->attribute_id
                    ]
                ]);
            }
            $user->products()->detach();

            return new JsonResponse([
                'order' => $order
            ]);
        }
    }

    public function removeFromCart(Request $request) {
        $user = Auth::user();
        // $user->products()->detach($request->product_user_id);
        $user->products()->wherePivot('id', '=', $request->product_user_id)->detach();
        $products = $user->products;
        // $totalPrice = $this->calculatePrice();
        return new JsonResponse([
            'products' => $products,
            // 'totalPrice' => $totalPrice
        ]);
    }

}
