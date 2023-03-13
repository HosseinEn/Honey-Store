<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function make_slug($request, $separator = '-') {
        $string = is_null($request->slug) ? $request->name : $request->slug;
        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");;
        $string = preg_replace("/[^\w_\sءاآؤئبپتثجچحخدذرزژسشصضطظعغفقكکگلمنوهی]#u/", '', $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);
        return $string;
    }

    public function calculatePrice($products) {
        $totalPrice = 0;
        $discounts = Discount::get();
        $totalPriceAfterDiscount = 0;
        foreach ($products as $product) {
            $attribute_id = $product->cart->attribute_id;
            $quantity = $product->cart->quantity;
            $selectedAttribute = $product->attributes->where('id', $attribute_id)->first();
            $price = $selectedAttribute->attribute_product->price;
            $discount_id = $selectedAttribute->attribute_product->discount_id;
            $totalPrice += $price * $quantity;         
            
            if ($discount_id){
                $dis_val = $discounts->where('id', $discount_id)->first()->value;
                $productPriceAfterDiscount = $price * $quantity * (1 - $dis_val / 100); 
                $totalPriceAfterDiscount += $productPriceAfterDiscount; 
            }
            else{
                $totalPriceAfterDiscount = $totalPrice; 
            }
        }
        return [$totalPrice, $totalPriceAfterDiscount];
    }

}
