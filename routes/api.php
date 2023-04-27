<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Admin endpoints
Route::name('api.')->prefix('admin')->middleware('auth:sanctum', 'is_admin')->namespace('App\Http\Controllers\Api\Admin')->group(function()  {
    Route::apiResource('types', 'TypeController');
    Route::apiResource('attributes', 'AttributeController');
    Route::apiResource('products', 'ProductController');
    Route::apiResource('discounts', 'DiscountController');
    Route::apiResource('users', 'UserController');
    Route::get('toggle-is-admin/{user}', [App\Http\Controllers\Api\Admin\UserController::class, 'toggleIsAdminForUser']);
    Route::apiResource('orders', 'OrderController');
    Route::get('orders/user/{user}', [App\Http\Controllers\Api\Admin\OrderController::class, 'showUserOrder']);
    Route::get('orders/cancel-order/{order}', [App\Http\Controllers\Api\Admin\OrderController::class, 'cancelOrder']);
    Route::get('orders/update-status/{order}/{status}', [App\Http\Controllers\Api\Admin\OrderController::class, 'updateOrderStatus']);

});


// User endpoints
Route::middleware('auth:sanctum')->group(function() {
    Route::post('checkout-cart', [App\Http\Controllers\Api\CheckoutController::class, 'checkoutCart']);
    Route::controller(App\Http\Controllers\Api\CartController::class)->group(function() {
        Route::post('add-to-cart/{product}', 'addToCart');
        Route::get('cart', 'index');
        Route::post('cart/increase-amount', 'increaseAmount');
        Route::post('cart/decrease-amount', 'decreaseAmount');
        Route::post('cart/{product}', 'removeFromCart');
    });
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
    Route::controller(App\Http\Controllers\Api\OrderController::class)->group(function() {
        Route::get('user-order-products', 'showUserOrderProducts');
        Route::post('order-cancellation-request/{order}', 'orderCancellationRequest');
    });
    Route::get('user', function() {
        return response()->json([
            'name' => Auth::user()->name,
            'isAdmin' => Auth::user()->is_admin,
        ]);
    });
    Route::controller(App\Http\Controllers\Api\UserController::class)->group(function() {
        Route::post('/user-change-password', 'passwordUpdate');
        Route::get('/get-user', 'getUser');
        Route::post('/update-profile', 'updateProfile');
    });
});
Route::get('types', [App\Http\Controllers\Api\TypeController::class, 'index']);
Route::get('callback-payment', [App\Http\Controllers\Api\CheckoutController::class, 'paymentCallbackMethod'])->name('paymentCallbackURL');
Route::apiResource('products', App\Http\Controllers\Api\ProductController::class)->only('index', 'show');
Route::get('admin/orders/filtered-by-status/{status}', [App\Http\Controllers\Api\FilterController::class, 'ordersFilterByStatus']);

Route::get('/is-logged', function() {
    return response()->json([
        'isLogged' => Auth::check()
    ]);
});
Route::get('/is-admin', function() {
    return response()->json([
        'isAdmin' => Auth::check() && Auth::user()->is_admin
    ]);
});