<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservingRequest;
use App\Http\Resources\ReservingResource;
use App\Models\Reserving;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="ReservingSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Reserving ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="person_id",
 *        type="integer",
 *        description="Foreign key person",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="room_id",
 *        type="integer",
 *        description="Foreign key room",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="type_food",
 *        type="enum",
 *        description="Тип питания в отеле",
 *        nullable=false,
 *        example="BB"
 *    ),
 *     @OA\Property(
 *        property="arrival_time",
 *        type="string",
 *        description="День прибытия",
 *        nullable=false,
 *        example="date"
 *    ),
 *     @OA\Property(
 *        property="departure_time",
 *        type="string",
 *        description="День отбытия",
 *        nullable=false,
 *        example="date"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of route creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating route data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * 
 * @OA\Get(
 *     path="/api/reservings",
 *     tags={"Reservings"},
 *     summary="Вывод списка записей (index())",
 *     description="Доступ только авторизованным пользователям",
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Everything OK",
*         @OA\JsonContent(
*               ref="#/components/schemas/ReservingSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/reservings",
*      tags={"Reservings"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный route",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReservingSchema")
*       ),
*      @OA\Response(
*          response=400,
*          description="Bad Request"
*      ),
*      @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),
*      @OA\Response(
*          response=403,
*          description="Forbidden"
*      )
* )

* @OA\Get(
*      path="/api/reservings/{id}",
*      tags={"Reservings"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns reserving data",
*      @OA\Parameter(
*          name="id",
*          description="Route id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReservingSchema")
*       ),
*      @OA\Response(
*          response=400,
*          description="Bad Request"
*      ),
*      @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),
*      @OA\Response(
*          response=403,
*          description="Forbidden"
*      )
* )
*
* @OA\Put(
*      path="/api/reservings/{id}",
*      tags={"Reservings"},
*      summary="Обновление записи (update())",
*      description="Returns updated reserving data",
*      @OA\Parameter(
*          name="id",
*          description="Reserving id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/ReservingSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReservingSchema")
*       ),
*      @OA\Response(
*          response=400,
*          description="Bad Request"
*      ),
*      @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),
*      @OA\Response(
*          response=403,
*          description="Forbidden"
*      ),
*      @OA\Response(
*          response=404,
*          description="Resource Not Found"
*      )
* )

* @OA\Delete(
*      path="/api/reservings/{id}",
*      tags={"Reservings"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Reserving id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=204,
*          description="Successful operation",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),
*      @OA\Response(
*          response=403,
*          description="Forbidden"
*      ),
*      @OA\Response(
*          response=404,
*          description="Resource Not Found"
*      )
* )
*/
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
