<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class CheckoutController extends Controller
{
    
    public function checkoutCart(Request $request) {
        $user = Auth::user();
        if($user->products->isEmpty()) {
            throw ValidationException::withMessages([
                'message' => ['سبد خرید خالی است']
            ]);
        }
        else {
            $products = $user->products;
            $products->load('attributes');
            $this->validateProductsStock($products);
            list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice($products);
            $invoice = new Invoice;   
            $invoice->amount($totalPriceWithDiscount);
            $payment = Payment::callbackUrl(route('paymentCallbackURL', ['price' => $totalPriceWithDiscount, 'id' => $user->id]))->purchase(
                $invoice, 
                function($driver, $transactionId) use ($user, $totalPrice, $totalPriceWithDiscount, $invoice) {
                    $order_status = OrderStatus::where('name', 'پرداخت نشده')->first();
                    $order = Order::create([
                        'user_id' => $user->id,
                        'order_status_id' => $order_status->id,
                        'delivery_date' => null,
                        'total_price' => $totalPrice,
                        'price_with_discount' => $totalPriceWithDiscount,
                        'invoice_no' => $invoice->getUuid(),
                        'shipping_address' => 'random place',
                        'transaction_id' => $transactionId,
                        'reference_id' => null
                    ]);

                }
            )->pay()->toJson();
            return $payment;
        }

    }

    private function validateProductsStock($products) {
        foreach ($products as $product) {
            $selectedAttribute = $product->attributes->where('id', $product->cart->attribute_id)->first();
            if ($selectedAttribute->attribute_product->stock < $product->cart->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => [
                        'لطفا با توجه به تعداد سفارش را انجام دهید. تعداد موجود: ' . $selectedAttribute->attribute_product->stock
                        . ' محصول: ' . $product->name . ' وزن:' . $selectedAttribute->weight]
                ]);
            }
        }
    }

    
    public function paymentCallbackMethod(Request $request) {
        try {
            $receipt = Payment::amount($request->price)->transactionId($request->Authority)->verify();
            $referenceID =  $receipt->getReferenceId();
            $order = Order::where('transaction_id' , $request->Authority)->first();
            $order_status = OrderStatus::where('name', 'تایید شده')->first();
            $user = $order->user;
            $products = $user->products;
            $products->load('attributes');
            DB::beginTransaction();
            foreach ($products as $product) {
                $selectedAttribute = $product->attributes->where('id', $product->cart->attribute_id)->first();
                $product->update(["stock" => $product->stock - $product->cart->quantity]);

                // stock will only accept positive values. when column has negative value, then race condition has happened.
                try {
                    $selectedAttribute->products()->where('product_id', $product->id)->decrement('attribute_product.stock', $product->cart->quantity);
                } catch(Exception $e) {
                    DB::rollBack();
                    // TODO refund mony
                    $order->update([
                        'description' => 'ثبت همزمان دو سفارش و موجودی ناکافی محصول. وجه باید استرداد شود.',
                        'order_status_id' => OrderStatus::where('name', 'نیاز به استرداد وجه')->first()->id
                    ]);
                    DB::commit();
                    throw new InvalidPaymentException('مشکلی در سامانه رخ داده است. مبلغ پرداختی تا ساعات آینده بازگشت داده می‌شود. در غیر این صورت با پشتیبانی تماس حاصل فرمایید.!');
                }

                $order->products()->attach([
                    $product->id => [
                        'quantity' => $product->cart->quantity,
                        'attribute_id' => $product->cart->attribute_id
                    ]
                ]);
            }
            $user->products()->detach();
            $order->update([
                'reference_id' => $referenceID,
                'order_status_id' => $order_status->id
            ]);  
            DB::commit();    
            return redirect("/user-orders");
        } catch (InvalidPaymentException $exception) {
            echo $exception->getMessage();
        }


    }


}
