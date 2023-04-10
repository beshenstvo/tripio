<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="PersonSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Person ID",
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
 *        property="name",
 *        type="string",
 *        description="Customer Name",
 *        nullable=false,
 *        example="Иван"
 *    ),
 *    @OA\Property(
 *        property="lastname",
 *        type="string",
 *        description="Customer lasname",
 *        nullable=false,
 *        example="Иванов"
 *    ),
 *     @OA\Property(
 *        property="patronymic",
 *        type="string",
 *        description="Customer patronymic",
 *        nullable=false,
 *        example="Иванович"
 *    ),
 *     @OA\Property(
 *        property="passport",
 *        type="string",
 *        description="Customer passport",
 *        nullable=false,
 *        example="4524761611"
 *    ),
 *     @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Customer email",
 *        nullable=false,
 *        example="example@test.ru"
 *    ),
 *  @OA\Property(
 *        property="phone",
 *        type="string",
 *        description="Customer phone",
 *        nullable=false,
 *        example="79999999999"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of person creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating person data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * 
 * 
 * @OA\Get(
 *     path="/api/persons",
 *     tags={"Persons"},
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
*               ref="#/components/schemas/PersonSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/persons",
*      tags={"Persons"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный город",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/PersonSchema")
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
*      path="/api/persons/{id}",
*      tags={"Persons"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns person data",
*      @OA\Parameter(
*          name="id",
*          description="Person id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/PersonSchema")
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
*      path="/api/persons/{id}",
*      tags={"Persons"},
*      summary="Обновление записи (update())",
*      description="Returns updated person data",
*      @OA\Parameter(
*          name="id",
*          description="Person id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/PersonSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/PersonSchema")
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
*      path="/api/persons/{id}",
*      tags={"Persons"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Person id",
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
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PersonResource::collection(Person::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonRequest $request)
    {
        $person = Person::create($request->validated());
        
        return new PersonResource($person);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new PersonResource(Person::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonRequest $request, Person $person)
    {
        $person->update($request->validated());

        return new PersonResource($person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
