<?php

use App\Http\Controllers\Api\CardCityController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FavoriteExcursionController;
use App\Http\Controllers\Api\FavoriteRouteController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\PersonController;
use App\Http\Controllers\Api\ReadyRouteController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\Api\ReservingController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ShowPlaceController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AdminAuthenticationController;
use App\Http\Controllers\Auth\GuideAuthenticationController;
use App\Http\Controllers\Auth\UserAuthenticationController as AuthUserAuthenticationController;
use App\Http\Controllers\ImageController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnSelf;

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

# регистрация пользователя
Route::post('register', [AuthUserAuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthUserAuthenticationController::class, 'login'])->name('login');
Route::post('logout', [AuthUserAuthenticationController::class, 'logout'])->name('logout');

# регистрация пользователя
Route::post('/admin.register', [AdminAuthenticationController::class, 'register'])->name('admin.register');
Route::post('/admin.login', [AdminAuthenticationController::class, 'login'])->name('admin.login');
Route::post('/admin.logout', [AdminAuthenticationController::class, 'logout'])->name('admin.logout');

# регистрация giude
Route::post('/guide.register', [GuideAuthenticationController::class, 'register'])->name('giude.register');
Route::post('/guide.login', [GuideAuthenticationController::class, 'login'])->name('giude.login');
Route::post('/guide.logout', [GuideAuthenticationController::class, 'logout'])->name('giude.logout');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResources([
        'themes' => ThemeController::class,
        'citycards' => CardCityController::class,
        'routes' => ReadyRouteController::class,
        'comments' => CommentController::class,
        'hotels' => HotelController::class,
        'persons' => PersonController::class,
        'services' => ServiceController::class,
        'reservings' => ReservingController::class,
        'reviews' => ReviewController::class,
        'rooms' => RoomController::class,
        'showplaces' => ShowPlaceController::class,
        'users' => UserController::class,
        'favorite_routes' => FavoriteRouteController::class,
        'favorite_exc' => FavoriteExcursionController::class
    ]);
    Route::get('/searchService', 'App\Http\Controllers\Api\ServiceController@searchService');
    Route::post('/users/{id}/block/{end_date}/{role}', 'App\Http\Controllers\Api\UserController@blockUser');
    Route::post('/users/{id}/unlock/{role}', 'App\Http\Controllers\Api\UserController@unlockUser');

});

# роуты для гостя
Route::get('servicesAll', 'App\Http\Controllers\Api\ServiceController@indexAll');
Route::get('services/{service}', 'App\Http\Controllers\Api\ServiceController@show');
Route::get('routes', 'App\Http\Controllers\Api\ReadyRouteController@index');
Route::get('routes/{route}', 'App\Http\Controllers\Api\ReadyRouteController@show');
Route::apiResource('cities', CityController::class);
Route::apiResource('requests', RequestController::class);


Route::middleware('auth:sanctum')->get('/user', function(Request $request) {
    return $request->user();
});

Route::get('image/{path}', [ImageController::class, 'getImage'])->where('path', '.*');
