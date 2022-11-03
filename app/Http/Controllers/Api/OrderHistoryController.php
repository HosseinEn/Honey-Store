<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class OrderHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user)
    {
        $orders = $user->orders;
        return new JsonResponse([
            'orders' => $orders,
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


        $products = $order->products;

        $products->load('attributes');

        foreach ($products as $product) {

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

        $order->update(["order_status_id"=>$order_status->id]);

        return new JsonResponse([
            'order' => $order
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
