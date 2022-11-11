<?php

use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
    Route::apiResource('orders', 'OrderController');
    Route::get('orders/user/{user}', [App\Http\Controllers\Api\Admin\OrderController::class, 'showUserOrder']);
    Route::get('orders/cancel-order/{order}', [App\Http\Controllers\Api\Admin\OrderController::class, 'cancelOrder']);

});

// User endpoints
Route::middleware('auth:sanctum')->group(function() {
    Route::controller(App\Http\Controllers\Api\ProductUserController::class)->group(function() {
        Route::post('add-to-cart/{product}', 'addToCart');
        Route::post('check-out-cart', 'checkoutCart');
        Route::get('cart', 'index');
        Route::post('cart/increase-amount', 'increaseAmount');
        Route::post('cart/decrease-amount', 'decreaseAmount');
        Route::post('cart/{product}', 'removeFromCart');
    });
    Route::apiResource('orders', App\Http\Controllers\Api\OrderController::class);
    Route::controller(App\Http\Controllers\Api\OrderController::class)->group(function() {
        Route::get('user-order-products/{order}', 'showUserOrderProducts');
        Route::post('order-cancellation-request/{order}', 'orderCancellationRequest');
    });
});

Route::apiResource('products', App\Http\Controllers\Api\ProductController::class)->only('index', 'show');
Route::controller(App\Http\Controllers\Api\FilterController::class)->group(function() {
    Route::get('most-sale-product', 'filterByMostSale');
    Route::get('most-expensive-product', 'filterByMostExpensive');
    Route::get('cheapest-product', 'filterByCheapest');
    Route::get('most-discounted-product', 'filterByMostDiscounted');
    Route::get('types/{type}', 'filterByType');
});
Route::get('/is-logged', function() {
    return response()->json([
        'isLogged' => Auth::check()
    ]);
});