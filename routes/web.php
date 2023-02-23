<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

Route::get('/show-map', function() {
    $img = Http::withHeaders([
        'x-api-key' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjA3N2U0MmNiYTVhMzAzMjdjNTVjZmRkMzA2ZjNlMGJhOWI3NGUwYTM0MDU1ZTZhZDMxNmM0YTIzMTQwMWFjODY4MTg3MWM0YjI5YTM0OWUxIn0.eyJhdWQiOiIyMTE5MCIsImp0aSI6IjA3N2U0MmNiYTVhMzAzMjdjNTVjZmRkMzA2ZjNlMGJhOWI3NGUwYTM0MDU1ZTZhZDMxNmM0YTIzMTQwMWFjODY4MTg3MWM0YjI5YTM0OWUxIiwiaWF0IjoxNjc2ODkyMTEzLCJuYmYiOjE2NzY4OTIxMTMsImV4cCI6MTY3OTMxMTMxMywic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.aOkd-f6hRG3Y_GVINHmtumlkCD98vWbAytov5mXSh4yMXSAqookmK697vcqpserijSiI24T4FiJm0SG1cvAYlHYN7-MZTi3YoxxBVQ9cRHswuExqxk9APZbG1eXOl_fiwKfiQVrqesUfHaDLB4VQbeYf1KzCc4JWeXUl3ivd4qY9cy5LRHXayVEhwE3SwEZPF_7MT6Wsvi4LDlJZbXCe9qtUlOgMqJtEedjvncpnb54Hs6e1c5LCeRkYVmTPGrepQ_VoGEqGDakwkkSg2XTZqIks--Gbr1vZdccJRhofCOB5BmaKVb6BXxSB69-OVw2WV1zUEL6FPGojSUscEryTPw',
        // 'content-type' => 'image/png'
    ])->get('https://map.ir/static?width=700&height=400&zoom_level=12&type=default&markers=color%3Adefault%7Clabel%3A%D9%85%D9%BE%7C51.422174%2C35.732469');
    // return 
    // return response()->file($filepath);
    // $img->store('public');
    return response($img)->header('Content-type','image/png');
    // dd($img);
    
});

Route::get('/{any}', function () {
    $isLogged = Auth::check();
    return view('welcome', [
        'isLogged' => $isLogged,
        'isAdmin' => $isLogged && Auth::user()->is_admin
    ]);
})->where('any', '^(?!api\/)[\/\w\.-]*');

Auth::routes();


