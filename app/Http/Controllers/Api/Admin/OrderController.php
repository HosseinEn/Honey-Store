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
        $request->has('search_key') ? $orders->search(trim($request->search_key)) : null;
        ($request->has('status') && $request->status != 'all') ? $orders->filterByStatus($request->status): null;
        ($request->has('from') && $request->has('to')) ? $orders->filterByDate($request->from, $request->to) : null;

        $orders = $orders->paginate(10);

        $attributes = Attribute::get();
        $orderStatuses = OrderStatus::get();

        foreach($orders as $order) {
            $order['order_status_text'] = $orderStatuses->where('id', $order->order_status_id)->first()->name;
            foreach($order->products as $product) {
                $product->ordered->attribute = $attributes->where('id', $product->ordered->attribute_id)->first();
            }
        }
        $paymentDoneStatus = $orderStatuses->where('name', 'تایید شده')->first()->id;
        $totalOrderPrice = $orders->where('order_status_id', $paymentDoneStatus)
                                  ->sum('price_with_discount');
        $totalOrderPriceThisMonth = $orders->where('order_status_id', $paymentDoneStatus)
                                           ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                                           ->sum('price_with_discount');
        return new JsonResponse([
            'orders' => $orders,
            'orderStatuses' => $orderStatuses,
            'totalOrderPrice' => $totalOrderPrice,
            'totalOrderPriceThisMonth' => $totalOrderPriceThisMonth
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
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
