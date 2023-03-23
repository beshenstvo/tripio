<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityCardRequest;
use App\Http\Resources\CityCardResource;
use App\Models\Card_city;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class CardCityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CityCardResource::collection(Card_city::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityCardRequest $request)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #create 
            Card_city::create([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created'
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Card_city::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityCardRequest $request, $id)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #update 
            $card = Card_city::find($id);
            $card->update([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => $card
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Card_city::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
