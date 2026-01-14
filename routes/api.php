<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;










/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



 Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'profile']);

});
#----------------------------------brands module---------------------------------#
Route::get('brands', [BrandsController::class, 'index']);
Route::get('brands/{id}', [BrandsController::class, 'show']);
Route::post('brands', [BrandsController::class, 'store']);
Route::put('brands/{id}', [BrandsController::class, 'update_brand']);
Route::delete('brands/{id}', [BrandsController::class, 'brand_delete']);


#----------------------------------location module---------------------------------#
Route::post('Location', [LocationController::class, 'location']);
Route::put('update_Location/{id}', [LocationController::class, 'update_location']);
Route::delete('delete_Location/{id}', [LocationController::class, 'location_delete']);

#----------------------------------product module---------------------------------#
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('update_products/{id}', [ProductController::class, 'update_product']);
Route::delete('delete_products/{id}', [ProductController::class, 'product_delete']);
#----------------------------------order module---------------------------------#
Route::get('order', [OrderController::class, 'index']);
Route::get('order/{id}', [OrderController::class, 'show']);
Route::post('order', [OrderController::class, 'store']);
Route::put('update_order/{id}', [OrderController::class, 'update_order']);
Route::delete('delete_order/{id}', [OrderController::class, 'order_delete']);
