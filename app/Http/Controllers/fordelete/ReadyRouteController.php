<?php

namespace App\Http\Controllers;

use App\Models\Ready_route;
use Illuminate\Http\Request;

class ReadyRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Ready_route::all();

        return view('user.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReadyRoutes  $readyRoutes
     * @return \Illuminate\Http\Response
     */
    public function show(Ready_route $readyRoutes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReadyRoutes  $readyRoutes
     * @return \Illuminate\Http\Response
     */
    public function edit(Ready_route $readyRoutes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReadyRoutes  $readyRoutes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ready_route $readyRoutes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReadyRoutes  $readyRoutes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ready_route $readyRoutes)
    {
        //
    }
}
