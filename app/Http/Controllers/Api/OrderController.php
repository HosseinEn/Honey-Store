<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        $orders->load('products');
        $attributes = Attribute::get();
        foreach($orders as $order) {
            foreach($order->products as $product) {
                $product->ordered->attribute = $attributes->where('id', $product->ordered->attribute_id)->first();
            }
        }
        $order_statuses = OrderStatus::get();
        foreach($orders as $order) {
            $order->order_status_text = $order_statuses->where('id', $order->order_status_id)->first()->name;
        }
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
            'success' => 'درخواست لغو شما با موفقیت ثبت شد. از بخش سفارشات خود وضعیت سفارش را پیگیری کنید'
        ]);
    }
}
