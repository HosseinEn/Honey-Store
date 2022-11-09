<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy("created_at", "desc")->get();
        $totalOrderPrice = Order::get()->sum('total_price');
        return new JsonResponse([
            'orders' => $orders,
            'totalOrderPrice' => $totalOrderPrice
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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

        // DB::connection()->enableQueryLog();

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

            $order_status = OrderStatus::where('name', 'لغو شده')->first();
            
            // static status_date
            $order->order_statuses()->attach([
                $order_status->id => [
                    'status_date' => now(),
                ]
            ]);

            // $order->products()->detach(); 
        }

        // dd(DB::getQueryLog());

        $order->update(["order_status_id"=>$order_status->id]);

        return new JsonResponse([
            'order' => $order
        ]);
    }
}
