<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index() {
        $products = Auth::user()->products;
        $products->load([
            'type',
            'attributes'
        ]);
        $discount_ids = $products->pluck('attributes')->collapse()->pluck('attribute_product')->pluck('discount_id');
        $discounts = Discount::whereIn('id', $discount_ids)->get();
        $products->map(function($product) use ($discounts) {
            $product->attributes->map(function($attribute) use ($discounts, $product) {
                $discount = $discounts->where('id', $attribute->attribute_product->discount_id)->first();
                if (!empty($discount)) {
                    $attribute->attribute_product->discount = $discount;
                }
                if($product->cart->attribute_id == $attribute->id) {
                    $product->selected_attribute = $attribute;
                }
            });
        });
        list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice($products);
        return new JsonResponse([
            'name_of_user' => Auth::user()->name,
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

    public function removeFromCart(Request $request) {
        $user = Auth::user();
        $user->products()->wherePivot('id', '=', $request->product_user_id)->detach();
        $products = $user->products;
        return new JsonResponse([
            'products' => $products,
            'success' => 'محصول با موفقیت از سبد خرید حذف شد!' 
        ]);
    }
}
