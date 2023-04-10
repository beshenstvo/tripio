<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="ServiceSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Service ID",
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
 *        property="user_id",
 *        type="integer",
 *        description="Foreign key user",
 *        nullable=false,
 *        example="standard double"
 *    ),
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Название короткое услуги",
 *        nullable=false,
 *        example="10500.99"
 *    ),
 *     @OA\Property(
 *        property="description",
 *        type="string",
 *        description="Описание экскурсии/услуги",
 *        nullable=false,
 *        example="Экскурсия по Казани"
 *    ),
 *     @OA\Property(
 *        property="price",
 *        type="float",
 *        description="Стоимость услуги",
 *        nullable=false,
 *        example="1500.67"
 *    ),
 *     @OA\Property(
 *        property="type",
 *        type="enum",
 *        description="Тип экскурсии",
 *        nullable=false,
 *        example="Индивидуальный"
 *    ),
 *     @OA\Property(
 *        property="kind",
 *        type="enum",
 *        description="Вид экскурсии",
 *        nullable=false,
 *        example="Городской"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of service creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating service data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * @OA\Get(
 *     path="/api/services",
 *     tags={"Services"},
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
*               ref="#/components/schemas/ServiceSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/services",
*      tags={"Services"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный service",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ServiceSchema")
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
*      path="/api/services/{id}",
*      tags={"Services"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns service data",
*      @OA\Parameter(
*          name="id",
*          description="Service id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ServiceSchema")
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
*      path="/api/services/{id}",
*      tags={"Services"},
*      summary="Обновление записи (update())",
*      description="Returns updated service data",
*      @OA\Parameter(
*          name="id",
*          description="Service id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/ServiceSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ServiceSchema")
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
*      path="/api/services/{id}",
*      tags={"Services"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Service id",
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
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ServiceResource::collection(Service::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());

        return new ServiceResource($service);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ServiceResource(Service::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->validated());

        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
