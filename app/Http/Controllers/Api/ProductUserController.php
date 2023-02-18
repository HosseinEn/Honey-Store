<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Discount;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use CodeDredd\Soap\SoapClient;
use Shetabit\Multipay\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Shetabit\Payment\Facade\Payment;
use App\Http\Requests\AddToCartRequest;
use Illuminate\Validation\ValidationException;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;


class ProductUserController extends Controller
{
    public function index() {
        $products = Auth::user()->products;
        $products->load([
            'type',
            'attributes'
        ]);
        $discount_ids = $products->pluck('attributes')->collapse()->pluck('attribute_product')->pluck('discount_id');
        $discounts = Discount::whereIn('id', $discount_ids)->get();
        $products->map(function($product) use ($discounts) {
            $product->attributes->map(function($attribute) use ($discounts, $product) {
                $discount = $discounts->where('id', $attribute->attribute_product->discount_id)->first();
                if (!empty($discount)) {
                    $attribute->attribute_product->discount = $discount;
                }
                if($product->cart->attribute_id == $attribute->id) {
                    $product->selected_attribute = $attribute;
                }
            });
        });
        list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice($products);
        return new JsonResponse([
            'name_of_user' => Auth::user()->name,
            'products' => $products,
            'totalPrice' => $totalPrice,
            'totalPriceWithDiscount' => $totalPriceWithDiscount
        ]);
    }

    public function increaseAmount(Request $request) {
        $request->validate([
            'product_user_id' => 'required'
        ]);
        $pivotRec = DB::table('product_user')->where('id', $request->product_user_id)->first();
        if (empty($pivotRec)) {
            throw ValidationException::withMessages([
                'product_user_id' => ['محصولی با مشخصات داده شده یافت نشد!']
            ]);
        }
        $quantity = $pivotRec->quantity + 1;
        $product = Product::findOrFail($pivotRec->product_id);
        $stock = $product->attributes->where('id', $pivotRec->attribute_id)->first()->attribute_product->stock;
        if ($stock < $quantity) {
            throw ValidationException::withMessages([
                'product_user_id' => ['امکان افزودن به کارت بیشتر از موجودی محصول امکان پذیر نمی باشد. موجودی: !' . $stock]
            ]);
        }
        DB::update('update product_user set quantity = ? where id = ?', [
            $quantity,
            $request->product_user_id
        ]);
        return DB::table('product_user')->where('id', $request->product_user_id)->get();
    }

    public function decreaseAmount(Request $request) {
        $request->validate([
            'product_user_id' => 'required'
        ]);
        $pivotRec = DB::table('product_user')->where('id', $request->product_user_id)->get();
        if ($pivotRec->isEmpty()) {
            throw ValidationException::withMessages([
                'product_user_id' => ['محصولی با مشخصات داده شده یافت نشد!']
            ]);
        }
        $quantity = $pivotRec->first()->quantity - 1;
        if ($quantity === 0) {
            throw ValidationException::withMessages([
                'product_user_id' => ['نمی توان تعداد را به صفر کاهش داد، لطفا در صورت تمایل محصول را از کارت حذف نمایید!']
            ]);
        }
        DB::update('update product_user set quantity = ? where id = ?', [
            $quantity,
            $request->product_user_id
        ]);
        return DB::table('product_user')->where('id', $request->product_user_id)->get();
    }

    private function calculatePrice($products) {
        $totalPrice = 0;
        $discounts = Discount::get();
        $totalPriceAfterDiscount = 0;
        foreach ($products as $product) {
            $attribute_id = $product->cart->attribute_id;
            $quantity = $product->cart->quantity;
            $selectedAttribute = $product->attributes->where('id', $attribute_id)->first();
            $price = $selectedAttribute->attribute_product->price;
            $discount_id = $selectedAttribute->attribute_product->discount_id;
            $totalPrice += $price * $quantity;         
            
            if ($discount_id){
                $dis_val = $discounts->where('id', $discount_id)->first()->value;
                $productPriceAfterDiscount = $price * $quantity * (1 - $dis_val / 100); 
                $totalPriceAfterDiscount += $productPriceAfterDiscount; 
            }
            else{
                $totalPriceAfterDiscount = $totalPrice; 
            }
        }
        return [$totalPrice, $totalPriceAfterDiscount];
    }

    public function addToCart(AddToCartRequest $request, Product $product) {     
        $user = Auth::user();
        $productAlreadyAddedToCart = DB::table('product_user')->where('attribute_id', $request->attribute_id)
                                                              ->where('product_id', $product->id)
                                                              ->where('user_id', $user->id)
                                                              ->exists();                                                    
        if($productAlreadyAddedToCart) {
            throw ValidationException::withMessages([
                'attribute_id' => ['محصول  با این وزن از قبل به کارت افزوده شده است!']
            ]);
        }

        $user->products()->attach([
            $product->id => [
                'quantity' => $request->quantity, 
                'attribute_id' => $request->attribute_id
            ]
        ]);

        return new JsonResponse([
            'success' => 'محصول با موفقیت به کارت افزوده شد!' 
        ]);
    }


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
                foreach ($products as $product) {
                    $selectedAttribute = $product->attributes->where('id', $product->cart->attribute_id)->first();
                    if ($selectedAttribute->attribute_product->stock < $product->cart->quantity) {
                        throw ValidationException::withMessages([
                            'quantity' => ['لطفا با توجه به تعداد سفارش را انجام دهید. تعداد موجود: ' . $selectedAttribute->attribute_product->stock
                            . ' محصول: ' . $product->name . ' وزن:' . $selectedAttribute->weight]
                        ]);
                    }
                }
                return $this->paymentResultMethod($user, $products);
        }

    }


    private function paymentResultMethod($user, $products) {        
            list($totalPrice, $totalPriceWithDiscount) = $this->calculatePrice($products);
            $invoice = new Invoice;   
            $invoice->amount($totalPriceWithDiscount);
            $payment = Payment::callbackUrl(route('paymentCallbackURL', ['price' => $totalPriceWithDiscount, 'id' => $user->id]))->purchase(
                $invoice, 
                function($driver, $transactionId) use ($user, $totalPriceWithDiscount, $invoice) {
                    $order_status = OrderStatus::where('name', 'در انتظار تایید اپراتور')->first();
                    $order = Order::create([
                        'user_id' => $user->id,
                        'order_status_id' => $order_status->id,
                        'delivery_date' => null,
                        'total_price' => $totalPriceWithDiscount,
                        'invoice_no' => $invoice->getUuid(),
                        'shipping_address' => 'bullshit',
                        'transaction_id' => $transactionId,
                        'reference_id' => null
                    ]);

                }
            )->pay()->toJson();
            return $payment;
    }

    
    public function paymentCallbackMethod(Request $request) {
        try {
            if ($request->has('price') && $request->has('Authority')) {
                $receipt = Payment::amount($request->price)->transactionId($request->Authority)->verify();
                $referenceID =  $receipt->getReferenceId();
                $order = Order::where('transaction_id' , $request->Authority)->first();
                $order_status = OrderStatus::where('name', 'در انتظار تایید اپراتور')->first();
                $user = $order->user;
                $products = $user->products;
                $products->load('attributes');
                $order->order_statuses()->attach([
                    $order_status->id => [
                        'status_date' => now(),
                    ]
                ]);
        
                foreach ($products as $product) {
                    $selectedAttribute = $product->attributes->where('id', $product->cart->attribute_id)->first();
                    $product->update(["stock" => $product->stock - $product->cart->quantity]);

                    DB::update('update attribute_product set stock = ? where attribute_id = ? and product_id = ?', [
                        
                        $selectedAttribute->attribute_product->stock -= $product->cart->quantity,
                        $product->cart->attribute_id,
                        $product->id
                    ]);

                    $order->products()->attach([
                        $product->id => [
                            'quantity' => $product->cart->quantity,
                            'attribute_id' => $product->cart->attribute_id
                        ]
                    ]);
                }
                $user->products()->detach();
                $order->update([
                    'reference_id' => $referenceID
                ]);
        
                new JsonResponse([
                    'order' => $order,
                ]);
            }
            else {
                return redirect('/');
            }        
            return redirect("/user-orders");
        } catch (InvalidPaymentException $exception) {
            echo $exception->getMessage();
        }


    }

    public function removeFromCart(Request $request) {
        $user = Auth::user();
        $user->products()->wherePivot('id', '=', $request->product_user_id)->detach();
        $products = $user->products;
        return new JsonResponse([
            'products' => $products,
            'success' => 'محصول با موفقیت از سبد خرید حذف شد!' 
        ]);
    }

}
