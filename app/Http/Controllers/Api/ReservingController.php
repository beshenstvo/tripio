<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservingRequest;
use App\Http\Resources\ReservingResource;
use App\Models\Reserving;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReservingResource::collection(Reserving::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservingRequest $request)
    {
        $service = Reserving::create($request->validated());

        return new ReservingResource($service);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ReservingResource(Reserving::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservingRequest $request, Reserving $reserving)
    {
        $reserving->update($request->validated());

        return new ReservingResource($reserving);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserving $reserving)
    {
        $reserving->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
