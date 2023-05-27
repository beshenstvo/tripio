<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteRouteRequest;
use App\Http\Resources\FavoriteRouteResource;
use App\Models\Favorite_route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FavoriteRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FavoriteRouteResource::collection(Favorite_route::with('route.cities', 'route.favorite_route')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavoriteRouteRequest $request)
    {
        $newCity = Favorite_route::create($request->validated());

        return new FavoriteRouteResource($newCity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new FavoriteRouteResource(Favorite_route::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FavoriteRouteRequest $request, Favorite_route $favorite_route)
    {
        $favorite_route->update($request->validated());

        return new FavoriteRouteResource($favorite_route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite_route $favorite_route)
    {
        $favorite_route->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
