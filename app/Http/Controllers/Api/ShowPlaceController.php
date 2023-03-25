<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowPlaceResource;
use App\Models\Showplace;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShowPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShowPlaceResource::collection(Showplace::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #create 
            $created = Showplace::create([
                'city_card_id' => $request->city_card_id,
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created',
                'data' =>  new ShowPlaceResource($created)
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
        return new ShowPlaceResource(Showplace::dinfOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #update 
            $showplace = Showplace::find($id);
            $showplace->update([
                'city_card_id' => $request->city_card_id,
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => new ShowPlaceResource($showplace)
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
    public function destroy($id)
    {
        Showplace::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
