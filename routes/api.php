<?php

use App\Http\Controllers\Admin\TypeController;
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

Route::prefix('v1')->name('api.v1.')->middleware('auth:sanctum')->namespace('App\Http\Controllers\Api\V1')->group(function()  {
    Route::apiResource('types', 'TypeController');
    Route::apiResource('attributes', 'AttributeController');
});

Route::fallback(function() {
    return new JsonResponse([
            'message' => "Model Not Found"
        ], 404);
})->name("api.fallback");


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/is-logged', function() {
    return response()->json([
        'isLogged' => Auth::check()
    ]);
});