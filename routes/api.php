<?php

use App\Http\Controllers\Api\CardCityController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\ReadyRouteController;
use App\Http\Controllers\ImageController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('image/{path}', [ImageController::class, 'getImage'])->where('path', '.*');

Route::apiResources([
    'citycard' => CardCityController::class,
	'routes' => ReadyRouteController::class,
    'city' => CityController::class
]);