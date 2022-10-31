<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductUserController extends Controller
{
    public function addToCart(Request $request, Product $product) {
        $user = Auth::user();
        $productAlreadyAddedToCart = DB::table('product_user')->where('attribute_id', $request->attribute_id)
                                                              ->where('product_id', $product->id)
                                                              ->exists();
        if($productAlreadyAddedToCart) {
            throw ValidationException::withMessages([
                'attribute_id' => ['محصول  با این وزن هم اکنون به کارت افزوده شد!']
            ]);
        }
        $request->validate([
            'quantity' => 'required|int|min:1',
            'attribute_id' => 'required|exists:attributes,id'
        ], [
            'quantity.required' => 'وارد کردن تعداد اجباری است!',
            'quantity.int' => 'لطفا یک عدد را برای تعداد وارد نمایید!',
            'quantity.min' => 'حداقل یک را برای تعداد می توانید وارد نمایید!',
            'attribute_id.required' => 'لطفا یک گزینه از وزن ها را انتخاب نمایید!',
            'attribute_id.exists' => 'یک گزینه معتبر انتخاب نمایید! '
        ]);
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
