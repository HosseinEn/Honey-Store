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
    public function sortBy(Request $request) {
        if ($request->has('sortBy')) {
            if ($request->sortBy === "mostSale") {
                $products = $this->sortByMostSale();
            }
            else if ($request->sortBy === "cheapest") {
                $products = $this->sortByCheapest();
            }
            else if ($request->sortBy === "mostExpensive") {
                $products = $this->sortByMostExpensive();

            }
            else if ($request->sortBy === "mostDiscounted") { 
                $products = $this->sortByMostDiscounted();
            }
            return new JsonResponse([
                'products' => $products
            ]);
        }
        else {
            return new JsonResponse([
                'products' => Product::with([
                    'image', 
                    'type' => function($query) {
                        return $query->select('id', 'name');
                    }
                ])
                  ->select('products.name', 'products.id', 'products.type_id', 'products.slug')
                  ->latest()
                  ->isActive()
                  ->paginate(10)
            ]);
        
        }
    }

    private function sortByMostSale() {
        $products = Product::with([
            'image',
            'type' => function($query) {
                return $query->select('id', 'name');
            }])
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->select(
                'products.id', 
                'products.name', 
                'products.type_id', 
                'products.slug',
                DB::raw('count(order_product.product_id) as count_sale'))
            ->groupBy('order_product.product_id')
            ->orderBy('count_sale', 'desc')
            ->isActive()
            ->paginate(10);
        return $products;
    }

    private function sortByMostExpensive() {
        $products = Product::with([
                            'image',
                            'type' => function($query) {
                                return $query->select('id', 'name');
                            }
                        ])
                        ->select(
                            'products.name', 
                            'products.id', 
                            'attributes.weight',
                            'products.type_id',
                            'products.slug',
                            'attribute_product.price'
                        )
                        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
                        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
                        ->orderBy('attribute_product.price', 'desc')
                        ->isActive()
                        ->paginate(10);
        return $products;
    }

    private function sortByCheapest() {
        $products = Product::with([
                            'image',
                            'type' => function($query) {
                                return $query->select('id', 'name');
                            }
                        ])
                        ->select(
                            'products.name', 
                            'products.id',
                            'products.slug',
                            'products.type_id',
                            'attributes.weight', 
                            'attribute_product.price'
                        )
                        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
                        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
                        ->orderBy('attribute_product.price', 'asc')
                        ->isActive()
                        ->paginate(10);
        return $products;
    }

    private function sortByMostDiscounted() {
        $products = Product::with([
                            'image', 
                            'type' => function($query) {
                                return $query->select('id', 'name');
                            }
                        ])
                        ->select(
                            'products.name', 
                            'products.id',
                            'products.slug',
                            'products.type_id',
                            'attributes.weight',
                            'attribute_product.price',
                            DB::raw('discounts.name as discount_name, discounts.value as discount_value')
                        )
                        ->join('attribute_product', 'products.id', 'attribute_product.product_id')
                        ->join('discounts', 'discounts.id', 'attribute_product.discount_id')
                        ->join('attributes', 'attributes.id', 'attribute_product.attribute_id')
                        ->orderBy('discounts.value', 'desc')
                        ->isActive()
                        ->paginate(10);
        return $products;
    }
}
