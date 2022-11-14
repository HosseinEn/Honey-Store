<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class SortController extends Controller
{
    private function getProductsByIDs($allProducts, $product_attribute_ids, $filteredBy) {
        $result = collect([]);
        foreach($product_attribute_ids as $pa_id) {
            $product = $allProducts->where('id', $pa_id->product_id)->first();
            if($product['attributes']) {
                $attribute = collect($product['attributes'])
                        ->where('attribute_product.stock', '!=', 0)
                        ->where('id', $pa_id->attribute_id)->first();
                if ($attribute) {
                    $result->push([
                        'product' => $product, 
                        'filteredAttribute' => $attribute
                    ]);
                }
            }
        }
        return $result;
    }

  
    public function sortBy(Request $request) {
        $products = collect($request->products);
        if ($request->has('sortBy')) {
            if ($request->sortBy === "mostSale") {
                $mostSaleProducts = $this->filterByMostSale($products);
                return new JsonResponse([
                    'filteredData' => $mostSaleProducts,
                ]);
            }
            else if ($request->sortBy === "cheapest") {
                $cheapestProducts = $this->filterByCheapest($products);
                return new JsonResponse([
                    'filteredData' => $cheapestProducts,
                ]);
            }
            else if ($request->sortBy === "mostExpensive") {
                $mostExpensiveProducts = $this->filterByMostExpensive($products);
                return new JsonResponse([
                    'filteredData' => $mostExpensiveProducts,
                ]);
            }
            else if ($request->sortBy === "mostDiscounted") { 
                $mostDiscountedProducts = $this->filterByMostDiscounted($products);
                return new JsonResponse([
                    'filteredData' => $mostDiscountedProducts
                ]);
            }
        }
    }



    private function filterByMostSale($products) {
        $pivotMostSale = DB::table('order_product')
        ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id', 'attribute_id')
        ->orderBy('total_quantity', 'desc')
        ->get();

        $mostSaleProducts = $this->getProductsByIDs($products, $pivotMostSale, 'most_sale_attribute');
        
        return $mostSaleProducts;
    }

    public function filterByMostExpensive($products) {

        $pivotProducts = DB::table('attribute_product')
        ->select('product_id', 'attribute_id', 'price')
        ->get();
        $pivotMostExpensiveProducts = $pivotProducts->sortBy('price', null, true);
        $mostExpensiveProducts = $this->getProductsByIDs($products, $pivotMostExpensiveProducts, 'most_expensive_attribute');
        return $mostExpensiveProducts;
    }

    public function filterByCheapest($products) {
        $pivotProducts = DB::table('attribute_product')
        ->select('product_id', 'attribute_id', 'price')
        ->get();
        $pivotCheapestProducts = $pivotProducts->sortBy('price', null, false);
        $cheapestProducts = $this->getProductsByIDs($products, $pivotCheapestProducts, 'cheapest_attribute');
        return $cheapestProducts;
    }

    public function filterByMostDiscounted($products) {
        $mostDiscountedProducts = collect([]);
        $joinResult = DB::table('discounts')
            ->join('attribute_product', 'discounts.id', '=', 'attribute_product.discount_id')
            ->select('product_id', 'attribute_id', 'value')
            ->orderBy('discounts.value', 'desc')
            ->get();

        foreach($joinResult as $jr) {
            $product = $products->where('id', $jr->product_id)->first();
            if ($product['attributes']) {
                $attribute = collect($product['attributes'])
                    ->where('attribute_product.stock', '!=', 0)
                    ->where('id', $jr->attribute_id)->first();
                    if ($attribute) {
                        $attribute['attribute_product']['discount_value'] = $jr->value;
                        $mostDiscountedProducts->push([
                            'product' => $product, 
                            'filteredAttribute' => $attribute,
                            // 'discount_value' => $jr->value
                        ]);
                }
            }
        }
        return $mostDiscountedProducts;
    }
}
