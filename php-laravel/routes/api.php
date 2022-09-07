<?php

use App\Http\Controllers\Controller;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('products')->group(function() {
    Route::get('/', [Controller::class, 'getProducts']);
    Route::post('/', [Controller::class, 'createProduct']);
    Route::get('/{id}', [Controller::class, 'getProductById']);
    Route::patch('/{id}', [Controller::class, 'updateProduct']);
    Route::delete('/{id}', [Controller::class, 'deleteProduct']);
});
