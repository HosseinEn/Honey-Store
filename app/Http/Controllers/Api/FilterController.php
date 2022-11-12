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
    public function filterByType(Type $type) {
        $products = $type->products->where('status', 1);
        return new JsonResponse([
            'type' => $type,
        ]);
    }
}
