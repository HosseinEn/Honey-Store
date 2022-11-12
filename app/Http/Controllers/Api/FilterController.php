<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Models\Order;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderStatus;

class FilterController extends Controller
{

    public function ordersFilterByStatus(OrderStatus $status) {

        $orders = Order::get();
        $ordersFilteredByStatus = $orders->where('order_status_id', $status->id);
        $totalOrderPrice = $ordersFilteredByStatus->sum('total_price');

        return new JsonResponse([
            'ordersFilteredByStatus' => $ordersFilteredByStatus,
            'totalOrderPrice' => $totalOrderPrice
        ]);
        
    }

public function filterByType(Type $type) {
        $products = $type->products->where('status', 1);
        return new JsonResponse([
            'type' => $type,
        ]);
    }
}
