<?php

use Illuminate\Http\Request;
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
//Rotas de descontos
Route::group(["prefix" => 'discounts'],function(){
    Route::get("/",['as' => 'discounts.get','uses' => 'DiscountsController@index']);
    Route::post("/draw",['as' => 'discounts.draw','uses' => 'DiscountsController@draw']);
    Route::post("/cupom",['as' => 'discounts.cupom','uses' => 'DiscountsController@cupom']);
});

