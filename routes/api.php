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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::group(['prefix' => 'menu'], function () {
    Route::get('/', [\App\Http\Controllers\Api\MenuController::class, 'index']);
});

Route::group(['prefix' => 'cart'], function () {
    Route::match(['get', 'post'], '/', [\App\Http\Controllers\Api\CartController::class, 'cart']);
    Route::post('/checkout', [\App\Http\Controllers\Api\CartController::class, 'checkout']);
});

Route::group(['prefix' => 'transaction'], function (){
    Route::get('/', [\App\Http\Controllers\Api\TransactionController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\TransactionController::class, 'get_transaction_by_id']);
});
