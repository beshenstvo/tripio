<?php

use App\Http\Controllers\Api\CardCityController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\ReadyRouteController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\ReservingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ThemeController;
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
    'themes' =>ThemeController::class,
    'citycards' => CardCityController::class,
	'routes' => ReadyRouteController::class,
    'cities' => CityController::class,
    'comments' => CommentController::class,
    'hotels' => HotelController::class,
    'persons' => PersonController::class,
    'requests' => RequestController::class,
    'services' => ServiceController::class,
    'reservings' => ReservingController::class,
    'reviews' => ReviewController::class,
]);