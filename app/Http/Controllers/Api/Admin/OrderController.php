<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::with(['products', 'user'])
                        ->latest();
        $orders->when($request->has('search_key'), function($query) use ($request) {
            return $query->search(trim($request->search_key));
        });
        $orders->when($request->has('status') && $request->status != 'all', function($query) use ($request) {
            return $query->filterByStatus($request->status);
        });
        $orders->when($request->has('from') && $request->has('to'), function($query) use ($request) {
            return $query->filterByDate($request->from, $request->to);
        });

        $orderStatuses = OrderStatus::get();
        $paymentDoneStatus = $orderStatuses->where('name', 'تایید شده')->first()->id;
        $totalOrderPrice = Order::where('order_status_id', $paymentDoneStatus)
                                  ->sum('price_with_discount');
        $totalOrderPriceThisMonth = Order::where('order_status_id', $paymentDoneStatus)
                                           ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                                           ->sum('price_with_discount');

        $orders = $orders->paginate(10);
        $attributes = Attribute::get();

        foreach($orders as $order) {
            $order['order_status_text'] = $orderStatuses->where('id', $order->order_status_id)->first()->name;
            foreach($order->products as $product) {
                $product->ordered->attribute = $attributes->where('id', $product->ordered->attribute_id)->first();
            }
        }

        return new JsonResponse([
            'orders' => $orders,
            'orderStatuses' => $orderStatuses,
            'totalOrderPrice' => $totalOrderPrice,
            'totalOrderPriceThisMonth' => $totalOrderPriceThisMonth
        ]);
    }

    public function showUserOrder(User $user) {
        
        $orders = $user->orders;
        $canceledOrderStatus = OrderStatus::where('name', 'لغو شده')->first();

        $totalSpent = $user->orders->where('order_status_id','!=', $canceledOrderStatus->id)->sum('total_price');
        return new JsonResponse([
            'orders' => $orders,
            'totalSpent' => $totalSpent,
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order, OrderStatus $status)
    {

        $request->validate([
            "order_status_id" => "integer",
        ], [
            "order_status_id.integer" => 'مقدار عددی باید ثبت شود!',
        ]);

        // static status_date
        $order->order_statuses()->syncWithoutDetaching([
            $status->id => [
                'status_date' => now(),
            ]
        ]);

        $order->update(["order_status_id"=>$status->id]);

        if ($status->name == 'لغو شده') {

            $products = $order->products;
            $products->load('attributes');

            foreach ($products as $product) {

                $product->update(["stock" => $product->stock + $product->ordered->quantity]);
                $selectedAttribute = $product->attributes->where('id', $product->ordered->attribute_id)->first();

                DB::update('update attribute_product set stock = ? where attribute_id = ? and product_id = ?', [
                    $selectedAttribute->attribute_product->stock += $product->ordered->quantity,
                    $product->ordered->attribute_id,
                    $product->id
                ]);
            }

            // static status_date
            $order->order_statuses()->syncWithoutDetaching([
                $status->id => [
                    'status_date' => now(),
                ]
            ]);

            $order->products()->detach();
        }
        $order['order_status_text'] = $status->name;
        return new JsonResponse([
            'order' => $order,
            'success' => 'وضعیت سفارش با موفقیت تغییر کرد!'
        ]);
    }

    public function cancelOrder(Order $order, Request $request)
    {
        if (OrderStatus::findOrFail($order->order_status_id)->name == 'ارسال شده') {
            throw ValidationException::withMessages([
                'order_status_id' => ['سفارش موردنظر در مرحله ارسال است و لغو آن امکان پذیر نمی‌باشد']
            ]);
        }
        
        if (OrderStatus::findOrFail($order->order_status_id)->name == 'لغو شده') {
            throw ValidationException::withMessages([
                'order_status_id' => ['این سفارش از پیش لغو شده است']
            ]);
        }

        $order_status = OrderStatus::where('name', 'لغو شده')->first();

        $order->order_statuses()->syncWithoutDetaching([
            $order_status->id => [
                'status_date' => now(),
            ]
        ]);

        $order->update(["order_status_id"=>$order_status->id]);
        return new JsonResponse([
            'order' => $order,
            'success' => 'سفارش با موفقیت لغو شد'
        ]);
    }
}
