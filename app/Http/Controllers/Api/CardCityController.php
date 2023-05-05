<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityCardRequest;
use App\Http\Resources\CityCardResource;
use App\Models\Card_city;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

/**
 * @OA\Schema(
 *    schema="CardCitySchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="CityCard ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *  @OA\Property(
 *        property="city_id",
 *        type="integer",
 *        description="Foreign key city",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Заголовок артикля",
 *        nullable=false,
 *        example="Поговорим о городе Казань"
 *    ),
 *    @OA\Property(
 *        property="description",
 *        type="string",
 *        description="Описание города",
 *        nullable=false,
 *        example="Казань – один из старейших городов России расположен на берегу Волги, в 820-ти километрах от Москвы. Столица Татарстана, где проживают представители 115 национальностей. Более 50% населения татары, на втором месте по численности – русские. Русский и татарский являются государственными и равноправными языками."
 *    ),
 *    @OA\Property(
 *        property="photo",
 *        type="text",
 *        description="Путь до файла",
 *        nullable=false,
 *        example="Казань"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of citycard creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating citycard data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * 
 * 
 * @OA\Get(
 *     path="/api/citycards",
 *     tags={"CityCards"},
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
*               ref="#/components/schemas/CardCitySchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/citycards",
*      tags={"CityCards"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный citycard",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/CardCitySchema")
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
*      path="/api/citycards/{id}",
*      tags={"CityCards"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns citycard data",
*      @OA\Parameter(
*          name="id",
*          description="City id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/CardCitySchema")
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
*      path="/api/citycards/{id}",
*      tags={"CityCards"},
*      summary="Обновление записи (update())",
*      description="Returns updated citycard data",
*      @OA\Parameter(
*          name="id",
*          description="City id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/CardCitySchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/CardCitySchema")
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
*      path="/api/citycards/{id}",
*      tags={"CityCards"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="City id",
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
class CardCityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CityCardResource::collection(Card_city::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityCardRequest $request)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #create 
            $data = Card_city::create([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created',
                'data' => new CityCardResource ($data)
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Card_city::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityCardRequest $request, $id)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #update 
            $card = Card_city::find($id);
            $card->update([
                'city_id' => $request->city_id,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image,
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => $card
            ], 200);


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Card_city::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
