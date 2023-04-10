<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="RoomSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Room ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="hotel_id",
 *        type="integer",
 *        description="Foreign key hotel",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="type",
 *        type="enum",
 *        description="Тип комнаты",
 *        nullable=false,
 *        example="standard double"
 *    ),
 *    @OA\Property(
 *        property="price",
 *        type="float",
 *        description="Стоимость номера",
 *        nullable=false,
 *        example="10500.99"
 *    ),
 *     @OA\Property(
 *        property="status",
 *        type="tinyint",
 *        description="Занят номер (0) или нет (1)",
 *        nullable=false,
 *        example="0"
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
 * @OA\Get(
 *     path="/api/rooms",
 *     tags={"Rooms"},
 *     summary="Вывод списка записей (index())",
 *     description="Доступ только авторизованным пользователям",
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     ),
 *     @OA\Response(
 *        response=200,
 *        description="Everything OK",
*         @OA\JsonContent(
*               ref="#/components/schemas/RoomSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/rooms",
*      tags={"Rooms"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный room",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/RoomSchema")
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
*      path="/api/rooms/{id}",
*      tags={"Rooms"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns room data",
*      @OA\Parameter(
*          name="id",
*          description="Room id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/RoomSchema")
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
*      path="/api/rooms/{id}",
*      tags={"Rooms"},
*      summary="Обновление записи (update())",
*      description="Returns updated room data",
*      @OA\Parameter(
*          name="id",
*          description="Room id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/RoomSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/RoomSchema")
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
*      path="/api/rooms/{id}",
*      tags={"Rooms"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Room id",
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

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoomResource::collection(Room::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $review = Room::create($request->validated());

        return new RoomResource($review);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RoomResource(Room::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return new RoomResource($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
