<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', function () {
    $isLogged = Auth::check();
    return view('welcome', [
        'isLogged' => $isLogged,
        'isAdmin' => $isLogged && Auth::user()->is_admin,
        'userName' => $isLogged ? Auth::user()->name : null
    ]);
})->where('any', '^(?!api\/)[\/\w\.-]*');

Auth::routes();