<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadyRoutesRequest;
use App\Http\Resources\ReadyRouteResource;
use App\Models\Ready_route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ReadyRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReadyRouteResource::collection(Ready_route::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReadyRoutesRequest $request)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #create 
            $data = Ready_route::create([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'duration' => $request->duration,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created',
                'data' => $data
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
        
        // $newRoute = Ready_route::create($request->validated());

        // return new ReadyRouteResource($newRoute);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ReadyRouteResource(Ready_route::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReadyRoutesRequest $request, $id)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #update 
            $route = Ready_route::find($id);
            $route->update([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'duration' => $request->duration,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => $route
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }

        // $route->update($request->validated());

        // return new ReadyRouteResource($route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ready_route $route)
    {
        $route->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
