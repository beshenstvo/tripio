<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRequest;
use App\Http\Resources\RequestResource;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RequestResource::collection(ModelsRequest::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestRequest $request)
    {
        $requestFromUser = ModelsRequest::create($request->validated());
        
        return new RequestResource($requestFromUser);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RequestResource(ModelsRequest::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequestRequest $requestFromServer, ModelsRequest $request)
    {
        $request->update($requestFromServer->validated());

        return new RequestResource($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsRequest $request)
    {
        $request->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
