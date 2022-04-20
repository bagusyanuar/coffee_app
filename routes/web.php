<?php

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

Route::match(['post', 'get'],'/', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);
Route::get('/fb', [\App\Http\Controllers\FirebaseController::class, 'index']);

Route::group(['prefix' => 'pengguna'], function (){
    Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\UserController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\UserController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\UserController::class, 'patch']);
});

Route::group(['prefix' => 'kategori'], function (){
    Route::get('/', [\App\Http\Controllers\CategoriesController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\CategoriesController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\CategoriesController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\CategoriesController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\CategoriesController::class, 'patch']);
});

Route::group(['prefix' => 'menu'], function (){
    Route::get('/', [\App\Http\Controllers\MenuController::class, 'index']);
    Route::get('/tambah', [\App\Http\Controllers\MenuController::class, 'add_page']);
    Route::post('/create', [\App\Http\Controllers\MenuController::class, 'create']);
    Route::get('/edit/{id}', [\App\Http\Controllers\MenuController::class, 'edit_page']);
    Route::post('/patch', [\App\Http\Controllers\MenuController::class, 'patch']);
});

Route::group(['prefix' => 'cart'], function(){
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index']);
});

Route::group(['prefix' => 'transaction'], function(){
    Route::post('/', [\App\Http\Controllers\TransactionController::class, 'confirm']);
    Route::get('/data', [\App\Http\Controllers\TransactionController::class, 'index']);
});
