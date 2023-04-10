<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="ReviewSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Review ID",
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
 *        property="showplaces_id",
 *        type="integer",
 *        description="Foreign key showplaces",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="user_id",
 *        type="integer",
 *        description="Foreign key user",
 *        nullable=false,
 *        example="1"
 *    ),
 *     @OA\Property(
 *        property="type",
 *        type="enum",
 *        description="На что отзыв",
 *        nullable=false,
 *        example="city"
 *    ),
 *     @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Короткое название отзыва",
 *        nullable=false,
 *        example="Понравилось."
 *    ),
 *     @OA\Property(
 *        property="description",
 *        type="string",
 *        description="Отзыв",
 *        nullable=false,
 *        example="Развитая инфраструктура, удобный общественный транспорт."
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
 *     path="/api/reviews",
 *     tags={"Reviews"},
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
*               ref="#/components/schemas/ReviewSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/reviews",
*      tags={"Reviews"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный reviews",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReviewSchema")
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
*      path="/api/reviews/{id}",
*      tags={"Reviews"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns review data",
*      @OA\Parameter(
*          name="id",
*          description="Review id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReviewSchema")
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
*      path="/api/reviews/{id}",
*      tags={"Reviews"},
*      summary="Обновление записи (update())",
*      description="Returns updated review data",
*      @OA\Parameter(
*          name="id",
*          description="Review id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/ReviewSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ReviewSchema")
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
*      path="/api/reviews/{id}",
*      tags={"Reviews"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Review id",
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
class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReviewResource::collection(Review::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
