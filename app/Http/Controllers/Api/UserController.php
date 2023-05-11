<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());
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
            if($request->photo) {
                $image = Str::random(32).".".$request->photo->getClientOriginalExtension();
                #create 
                $data = User::create([
                    'email' => $request->email,
                    'name' => $request->name,
                    'photo' => $image,
                ]);

                #сохранение изображения
                Storage::disk('public')->put($image, file_get_contents($request->photo));
            } else {
                $data = User::create([
                    'email' => $request->email,
                    'name' => $request->name,
                ]);
            }
            
            return response()->json([
                'message' => 'Created',
                'data' => $data
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
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            if($request->password) {
                #update 
                $data = User::find($id);
                $data->update([
                    'password' => Hash::make($request->password)
                ]);            
            } else {
                #update 
                $data = User::find($id);
                $data->update([
                    'email' => $request->email,
                    'name' => $request->name
                ]);
            }
            
            return response()->json([
                'message' => 'Updated',
                'data' => $data
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
    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
