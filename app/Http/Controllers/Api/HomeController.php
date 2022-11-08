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


    public function getProductsByIDs($allProducts, $product_attribute_ids) {
        $resultProducts = collect([]);
        foreach ($product_attribute_ids as $pa_id) {
            $singleProductModel = $allProducts->where('id', $pa_id->product_id);
            $singleProductModel->load(['attributes' => function ($query) use ($pa_id){
                $query->where('attributes.id', $pa_id->attribute_id);
            }]);
            $resultProducts->push($singleProductModel);
         }
         return $resultProducts;
    }

    public function index() {
        $products = Product::get();


        $pivotMostSale = DB::table('order_product')
        ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id', 'attribute_id')
        ->orderBy('total_quantity', 'desc')
        ->take(3)
        ->get();

        $mostSaleProducts = $this->getProductsByIDs($products, $pivotMostSale);
       
    



        $pivotProducts = DB::table('attribute_product')
        ->select('product_id', 'attribute_id');

        
        $pivotMostExpensiveProducts = $pivotProducts
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();

        $pivotCheapestProducts = $pivotProducts
            ->orderBy('price', 'asc')
            ->take(3)
            ->get(); 

        $mostExpensiveProducts = $this->getProductsByIDs($products, $pivotMostExpensiveProducts);

        $cheapestProducts = $this->getProductsByIDs($products, $pivotMostExpensiveProducts);





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
            // 'retrievedMostSaleProductModels' => $retrievedMostSaleProductModels,
            // 'MostExpensiveProducts' => $mostExpensiveProducts,
            // 'retrievedProductModels' => $retrievedExpensiveProductModels,
            // 'cheapestProducts' => $cheapestProducts,
            // 'retrievedProductModels' => $retrievedCheapestProductModels,
            'discountsPriorities' => $discountsPriorities,
            'orderedDiscounts' => $highestDiscounts,
        ]);
    }

}
