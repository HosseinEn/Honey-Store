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


    public function getProductsByIDs($allProducts, $product_attribute_ids, $filteredBy) {
        $result = collect([]);
        foreach($product_attribute_ids as $pa_id) {
            $product = $allProducts->where('id', $pa_id->product_id)->first();
            $result->push([
                'product' => $product, 
                $filteredBy => $product->attributes->where('id', $pa_id->attribute_id)->first()
            ]);
        }
        return $result;
    }

    public function index() {
        $products = Product::get();
        $products->load('attributes');


        $pivotMostSale = DB::table('order_product')
        ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id', 'attribute_id')
        ->orderBy('total_quantity', 'desc')
        ->take(3)
        ->get();

        $mostSaleProducts = $this->getProductsByIDs($products, $pivotMostSale, 'most_sale_attribute');
 
        $pivotProductsDesc = DB::table('attribute_product')
        ->select('product_id', 'attribute_id');


        $pivotProductsAsc = clone $pivotProductsDesc;
        
        $pivotMostExpensiveProducts = $pivotProductsDesc
            ->orderBy('price', 'desc')
            ->take(3)
            ->get();

        $pivotCheapestProducts = $pivotProductsAsc
            ->orderBy('price', 'asc')
            ->take(3)
            ->get(); 

        $mostExpensiveProducts = $this->getProductsByIDs($products, $pivotMostExpensiveProducts, 'most_expensive_attribute');
        $cheapestProducts = $this->getProductsByIDs($products, $pivotCheapestProducts, 'cheapest_attribute');
        
        $resultProducts = collect([]);
        $joinResult = DB::table('discounts')
            ->join('attribute_product', 'discounts.id', '=', 'attribute_product.discount_id')
            ->select('product_id', 'attribute_id', 'value')
            ->orderBy('discounts.value', 'desc')
            ->take(3)
            ->get();
        
        foreach($joinResult as $jr) {
            $product = $products->where('id', $jr->product_id)->first();
            $attributes = $product->attributes->where('id', $jr->attribute_id)->first();
            $resultProducts->push([
                'product' => $product, 
                'most_discounted_attribute' => $attributes
            ]);
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
            // 'discountsPriorities' => $discountsPriorities,
            // 'orderedDiscounts' => $highestDiscounts,
        ]);
    }

}
