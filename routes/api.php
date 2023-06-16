<?php

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

// api/v2
Route::group([
    'prefix' => 'v2',
    'namespace' => 'App\Http\Controllers\API\v2'
],
    function(){
        Route::apiResource('cities', CityController::class);
        Route::apiResource('companies', CompanyController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('items', ItemController::class);

        // User
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@login');
    }
);

