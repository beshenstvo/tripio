<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="HotelSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Hotel ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *  @OA\Property(
 *        property="user_id",
 *        type="integer",
 *        description="Foreign key user",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="city_id",
 *        type="integer",
 *        description="Foreign key city",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Название отеля",
 *        nullable=false,
 *        example="Diamond resort"
 *    ),
 *    @OA\Property(
 *        property="stars",
 *        type="enum",
 *        description="Количесвто звезд",
 *        nullable=false,
 *        example="5"
 *    ),
 *    @OA\Property(
 *        property="location",
 *        type="text",
 *        description="Адрес отеля",
 *        nullable=false,
 *        example="Москва, ул Бориса Галушкина, д 9"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of comment creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating comment data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * 
 * 
 * @OA\Get(
 *     path="/api/hotels",
 *     tags={"Hotels"},
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
*               ref="#/components/schemas/HotelSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/hotels",
*      tags={"Hotels"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный hotel",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/HotelSchema")
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
*      path="/api/hotels/{id}",
*      tags={"Hotels"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns hotel data",
*      @OA\Parameter(
*          name="id",
*          description="Hotel id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/HotelSchema")
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
*      path="/api/hotels/{id}",
*      tags={"Hotels"},
*      summary="Обновление записи (update())",
*      description="Returns updated hotel data",
*      @OA\Parameter(
*          name="id",
*          description="Hotel id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/HotelSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/HotelSchema")
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
*
* @OA\Delete(
*      path="/api/hotels/{id}",
*      tags={"Hotels"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Hotel id",
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
class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HotelResource::collection(Hotel::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HotelRequest $request)
    {
        $newCity = Hotel::create($request->validated());

        return new HotelResource($newCity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new HotelResource(Hotel::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $hotel->update($request->validated());

        return new HotelResource($hotel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
