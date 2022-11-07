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


// TODO add is_admin middleware
Route::name('api.')->prefix('admin')->middleware('auth:sanctum', 'is_admin')->namespace('App\Http\Controllers\Api\Admin')->group(function()  {
    Route::apiResource('types', 'TypeController');
    Route::apiResource('attributes', 'AttributeController');
    Route::apiResource('products', 'ProductController');
    Route::get('orders/{user}', [App\Http\Controllers\Api\Admin\OrderController::class, 'index'])->middleware('auth:sanctum');
    Route::get('orders/cancel-order/{order}', [App\Http\Controllers\Api\Admin\OrderController::class, 'cancelOrder'])->middleware('auth:sanctum');

});

Route::apiResource('products', App\Http\Controllers\Api\ProductController::class)->only('index', 'show');

Route::post('add-to-cart/{product}', [App\Http\Controllers\Api\ProductUserController::class, 'addToCart'])->middleware('auth:sanctum');
Route::post('checkout-cart', [App\Http\Controllers\Api\ProductUserController::class, 'checkoutCart'])->middleware('auth:sanctum');
Route::get('cart', [App\Http\Controllers\Api\ProductUserController::class, 'index'])->middleware('auth:sanctum');
Route::post('cart/increase-amount', [App\Http\Controllers\Api\ProductUserController::class, 'increaseAmount'])->middleware('auth:sanctum');
Route::post('cart/decrease-amount', [App\Http\Controllers\Api\ProductUserController::class, 'decreaseAmount'])->middleware('auth:sanctum');
Route::post('cart/{product}', [App\Http\Controllers\Api\ProductUserController::class, 'removeFromCart'])->middleware('auth:sanctum');
Route::get('callback-payment', [App\Http\Controllers\Api\ProductUserController::class, 'paymentCallbackMethod'])
                                                                    // ->middleware('auth:sanctum')
                                                                    ->name('paymentCallbackURL');
// Route::post('create-order', [App\Http\Controllers\Api\ProductUserController::class, 'createOrder'])
//                                                 ->middleware('auth:sanctum')
//                                                 ->name('create.order');


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/is-logged', function() {
    return response()->json([
        'isLogged' => Auth::check()
    ]);
});