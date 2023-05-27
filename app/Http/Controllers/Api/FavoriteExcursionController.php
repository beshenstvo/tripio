<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteExcursionRequest;
use App\Http\Resources\FavoriteExcursionResource;
use App\Models\Favorite_excursion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FavoriteExcursionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FavoriteExcursionResource::collection(Favorite_excursion::with('service.cities', 'service.favorite_service')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FavoriteExcursionRequest $request)
    {
        $newCity = Favorite_excursion::create($request->validated());

        return new FavoriteExcursionResource($newCity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new FavoriteExcursionResource(Favorite_excursion::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FavoriteExcursionRequest $request, Favorite_excursion $favorite_excursion)
    {
        $favorite_excursion->update($request->validated());

        return new FavoriteExcursionResource($favorite_excursion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Favorite_excursion::find($id)->delete();

            return response(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to delete resource', 'whatsWrong' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
