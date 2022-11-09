<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    private function getProductsByIDs($allProducts, $product_attribute_ids, $filteredBy) {
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

    public function filterByMostSale() {
        $products = Product::isActive()->get();
        $products->load('attributes');
        $pivotMostSale = DB::table('order_product')
        ->select('product_id', 'attribute_id', DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id', 'attribute_id')
        ->orderBy('total_quantity', 'desc')
        ->get();

        $mostSaleProducts = $this->getProductsByIDs($products, $pivotMostSale, 'most_sale_attribute');
        
        return new JsonResponse([
            'mostSaleProducts' => $mostSaleProducts,
        ]);
    }

    private function pivotDataForSortingByPrice() {
        $products = Product::isActive()->get();
        $products->load('attributes');
        $pivotProducts = DB::table('attribute_product')
        ->select('product_id', 'attribute_id', 'price')
        ->get();
        return [$products, $pivotProducts];
    }

    public function filterByMostExpensive() {
        list($products, $pivotProducts) = $this->pivotDataForSortingByPrice();
        $pivotMostExpensiveProducts = $pivotProducts->sortBy('price', null, true);
        $mostExpensiveProducts = $this->getProductsByIDs($products, $pivotMostExpensiveProducts, 'most_expensive_attribute');

        return new JsonResponse([
            'mostExpensiveProducts' => $mostExpensiveProducts,
        ]);
    }

    public function filterByCheapest() {
        list($products, $pivotProducts) = $this->pivotDataForSortingByPrice();
        $pivotCheapestProducts = $pivotProducts->sortBy('price', null, false);
        $cheapestProducts = $this->getProductsByIDs($products, $pivotCheapestProducts, 'cheapest_attribute');
        return new JsonResponse([
            'cheapestProducts' => $cheapestProducts,
        ]);
    }

    public function filterByMostDiscounted() {
        $products = Product::isActive()->get();
        $products->load('attributes');
      
        $mostDiscountedProducts = collect([]);
        $joinResult = DB::table('discounts')
            ->join('attribute_product', 'discounts.id', '=', 'attribute_product.discount_id')
            ->select('product_id', 'attribute_id', 'value')
            ->orderBy('discounts.value', 'desc')
            ->get();
        
        foreach($joinResult as $jr) {
            $product = $products->where('id', $jr->product_id)->first();
            $attributes = $product->attributes->where('id', $jr->attribute_id)->first();
            $mostDiscountedProducts->push([
                'product' => $product, 
                'most_discounted_attribute' => $attributes
            ]);
        }

        return new JsonResponse([
            'mostDiscountedProducts' => $mostDiscountedProducts
        ]);
    }

    public function filterByType(Type $type) {
        $products = $type->products->where('status', 1);
        return new JsonResponse([
            'type' => $type,
        ]);
    }
}
