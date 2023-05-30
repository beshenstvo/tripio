<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRequest;
use App\Http\Resources\RequestResource;
use App\Mail\Feedback;
use App\Models\Request as ModelsRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Schema(
 *    schema="RequestsSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Request ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="service_id",
 *        type="integer",
 *        description="Foreign key service",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="client_id",
 *        type="integer",
 *        description="Foreign key service",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="client_phone",
 *        type="string",
 *        description="Номер пользователя, кто оставил заявку на экскурсию",
 *        nullable=false,
 *        example="9786666666"
 *    ),
 *     @OA\Property(
 *        property="client_name",
 *        type="string",
 *        description="Имя пользователя, кто оставил заявку на экскурсию",
 *        nullable=false,
 *        example="Арина"
 *    ),
 *     @OA\Property(
 *        property="message",
 *        type="text",
 *        description="Сообщение пользователя",
 *        nullable=false,
 *        example="Хотим попасть к вам на экскурсию по Казани"
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
 * 
 * @OA\Get(
 *     path="/api/requests",
 *     tags={"Requests"},
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
*               ref="#/components/schemas/RequestsSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/requests",
*      tags={"Requests"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный route",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/RequestsSchema")
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
*      path="/api/requests/{id}",
*      tags={"Requests"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns request data",
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
*          @OA\JsonContent(ref="#/components/schemas/RequestsSchema")
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
*      path="/api/requests/{id}",
*      tags={"Requests"},
*      summary="Обновление записи (update())",
*      description="Returns updated request data",
*      @OA\Parameter(
*          name="id",
*          description="Request id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/RequestsSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/RequestsSchema")
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
*      path="/api/requests/{id}",
*      tags={"Requests"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Request id",
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
class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ModelsRequest::query();

        if ($request->has('archive') && $request->input('archive') == 0) {
          $query->where('archive', 0);
        } else {
            $query->where('archive', 1);
        }
      
        $id = auth()->id();

        return RequestResource::collection($query->join('services', 'requests.service_id', '=', 'services.id')
            ->where('services.user_id', $id)
            ->orderBy('requests.id', 'DESC')
            ->groupBy('requests.id')
            ->select([
                'requests.id',
                'requests.service_id',
                'requests.client_phone',
                'requests.client_name',
                'requests.message',
                'requests.archive'
                ])
            ->paginate(5)
        );
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
        
        $name = $request->client_name;
        $phone = $request->client_phone;
        $message = $request->message;

        $exc_name = Service::where('id', $request->service_id)->value('name');

        $guide_email = ModelsRequest::join('services', 'requests.service_id', '=', 'services.id')
        ->join('users', 'services.user_id', '=', 'users.id')
        ->where('services.id', $request->service_id)
        ->select('email')->first();
        
        // надо будет вставить в mail ro $guide_email->email;
        
        Mail::to('mufwoo@gmail.com')->send(new Feedback($name, $phone, $message, $exc_name));

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
