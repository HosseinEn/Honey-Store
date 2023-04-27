<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Type;

class ProductController extends Controller
{
    public function index(Request $request) {
        $types = Type::get();
        $products = Product::with([
            'image', 
            'type' => function($query) {
                return $query->select('id', 'name');
            }
        ]);
        $products->when($request->has('type'), function($query) use ($request) {
            return $query->where('type_id', $request->type);
        });
        if ($request->has('sortBy')) {
            switch($request->sortBy) {
                case 'mostSale':
                    $products = $products->sortByMostSale();
                    break;
                case 'cheapest':
                    $products = $products->sortByCheapest();
                    break;
                case 'mostExpensive':
                    $products = $products->sortByMostExpensive();
                    break;
                case 'mostDiscounted':
                    $products = $products->sortByMostDiscounted();
                    break;
            }
            $products = $products->isActive()->paginate(10);
        }
        else {
            $products = $products
                ->select('products.name', 'products.id', 'products.type_id', 'products.slug')
                ->latest()
                ->isActive()
                ->paginate(10);
                
        }
        return new JsonResponse([
            'products' => $products,
            'types' => $types,
        ]);
    }

    public function show(Product $product) {
        if($product->status != 1) {
            return abort(404);
        }
        $product->load([
            'attributes'  => function($query) {
                return $query->where('stock', '!=', 0);
            }, 
            'image',
            'type'
        ]);
        $minPrice = $product->attributes->min('attribute_product.price');
        $maxPrice = $product->attributes->max('attribute_product.price');
        return new JsonResponse([
            'product' => $product,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice
        ]);
    }
}
