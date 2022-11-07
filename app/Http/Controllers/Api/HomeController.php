<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index() {

        
        // $pivotMostSale = DB::table('order_product')
        // ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
        // ->groupBy('product_id', 'attribute_id')
        // ->orderBy('total_quantity', 'desc')
        // ->take(3)
        // ->get();

        // $retrivedMostSaleProductModels = collect([]);
        // foreach ($pivotMostSale as $rawProduct) {
        //     $singleProductModel = Product::where('id', $rawProduct->product_id)->get();
        //     $selectedAttribute = $singleProductModel->first()->attributes->where('id', $rawProduct->attribute_id)->first();
            
        //     // $singleProductModel->load('attributes');
            
        //     $singleProductModel->load(['attributes' => function ($query) use ($selectedAttribute){
        //         $query->where('attributes.id', $selectedAttribute->id);
        //     }]);

        //     $retrivedMostSaleProductModels->push($singleProductModel);
        // }



        // $mostExpensiveProducts = DB::table('attribute_product')
        // ->orderBy('price', 'desc')
        // ->take(3)
        // ->get();

        // $retrivedExpensiveProductModels = collect([]);
        // foreach ($mostExpensiveProducts as $rawProduct) {
        //     $singleProductModel = Product::where('id', $rawProduct->product_id)->get();
        //     $selectedAttribute = $singleProductModel->first()->attributes->where('id', $rawProduct->attribute_id)->first();
            
        //     // $singleProductModel->load('attributes');
            
        //     $singleProductModel->load(['attributes' => function ($query) use ($selectedAttribute){
        //         $query->where('attributes.id', $selectedAttribute->id);
        //     }]);

        //     $retrivedExpensiveProductModels->push($singleProductModel);
        // }


        // $cheapestProducts = DB::table('attribute_product')
        // ->orderBy('price', 'asc')
        // ->take(10)
        // ->get();
        
        // $retrivedCheapestProductModels = collect([]);
        // foreach ($cheapestProducts as $rawProduct) {
        //     $singleProductModel = Product::where('id', $rawProduct->product_id)->get();
        //     $selectedAttribute = $singleProductModel->first()->attributes->where('id', $rawProduct->attribute_id)->first();
            
        //     // $singleProductModel->load('attributes');
            
        //     $singleProductModel->load(['attributes' => function ($query) use ($selectedAttribute){
        //         $query->where('attributes.id', $selectedAttribute->id);
        //     }]);
            
        //     $retrivedCheapestProductModels->push($singleProductModel);
        // }





        $discountsPriorities = Discount::orderBy('value', 'desc')->pluck('id')->toArray();
        $pivotDiscounts = DB::table('attribute_product')->get()->toArray();

        $highestDiscounts = array();
        foreach ($discountsPriorities as $key) {

            foreach ($pivotDiscounts as $img) {
                if (count($highestDiscounts) === 5){
                    break 2;
                }
                if($img->discount_id == $key) {
                    $highestDiscounts[] = $img;
                }
            }

        }


        // $products = Product::with('image', 'type')->isActive()->get();
        return new JsonResponse([
            // 'products' => $products,
            // 'pivotRec' => $pivotMostSale,
            // 'retrivedMostSaleProductModels' => $retrivedMostSaleProductModels,
            // 'MostExpensiveProducts' => $mostExpensiveProducts,
            // 'retrivedProductModels' => $retrivedExpensiveProductModels,
            // 'cheapestProducts' => $cheapestProducts,
            // 'retrivedProductModels' => $retrivedCheapestProductModels,
            'discountsPriorities' => $discountsPriorities,
            'orderedDiscounts' => $highestDiscounts,
        ]);
    }

}
