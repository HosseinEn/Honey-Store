<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $orders = $user->orders;

        return new JsonResponse([
            'user_orders' => $orders
        ]);
    }

    // TODO Maybe not needed and loading data in index would be better.
    public function showUserOrderProducts() {
        // if (Gate::denies('view_order', $order)) {
        //     return abort(404);
        // }
        $user = Auth::user();
        $orders = $user->orders;
        // $order = $order->load('products');
        return new JsonResponse([
            'orders' => $orders,
        ]);
    }

    public function orderCancellationRequest(Order $order)
    {
        if (Gate::denies('view_order', $order)) {
            return abort(404);
        }
        $order_status = OrderStatus::where('name', 'درخواست لغو')->first();
        if ($order->order_status_id === $order_status->id) {
            // TODO Must be a type of error for front-end
            return new JsonResponse([
                'error' => 'درخواست لغو سفارش قبلا ثبت شده است!'
            ]);
        };
        $order->update([
            'order_status_id' => $order_status->id
        ]);
        return new JsonResponse([
            'success' => 'وضعیت سفارش شما با موفقیت تغییر کرد!'
        ]);
    }
}
