<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowPlaceResource;
use App\Models\Showplace;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *    schema="ShowplacesSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Showplace ID",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="city_card_id",
 *        type="integer",
 *        description="Foreign key citycard",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Название короткое достопримечательности",
 *        nullable=false,
 *        example="Музей им Пушкина"
 *    ),
 *     @OA\Property(
 *        property="description",
 *        type="string",
 *        description="Описание достопримечательности",
 *        nullable=false,
 *        example="Госуда́рственный музе́й изобрази́тельных иску́сств и́мени А. С. Пу́шкина — московский музей зарубежного искусства, основанный профессором Московского университета Иваном Цветаевым в 1912 году как «Музей изящных искусств имени императора Александра III при Императорском Московском университете»."
 *    ),
 *     @OA\Property(
 *        property="type",
 *        type="enum",
 *        description="Тип достопримечательности",
 *        nullable=false,
 *        example="museum"
 *    ),
 *     @OA\Property(
 *        property="photo",
 *        type="text",
 *        description="Путь до фото",
 *        nullable=false,
 *        example="File/file/photo.png"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Date of showplace creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating showplace data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * @OA\Get(
 *     path="/api/showplaces",
 *     tags={"Showplaces"},
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
*               ref="#/components/schemas/ShowplacesSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/showplaces",
*      tags={"Showplaces"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный showplace",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ShowplacesSchema")
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
*      path="/api/showplaces/{id}",
*      tags={"Showplaces"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns showplace data",
*      @OA\Parameter(
*          name="id",
*          description="Showplace id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ShowplacesSchema")
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
*      path="/api/showplaces/{id}",
*      tags={"Showplaces"},
*      summary="Обновление записи (update())",
*      description="Returns updated showplace data",
*      @OA\Parameter(
*          name="id",
*          description="Showplace id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/ShowplacesSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ShowplacesSchema")
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
*      path="/api/showplaces/{id}",
*      tags={"Showplaces"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Showplace id",
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
class ShowPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShowPlaceResource::collection(Showplace::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #create 
            $created = Showplace::create([
                'city_card_id' => $request->city_card_id,
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created',
                'data' =>  new ShowPlaceResource($created)
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
        return new ShowPlaceResource(Showplace::dinfOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $image = Str::random(32).".".$request->photo->getClientOriginalExtension();

            #update 
            $showplace = Showplace::find($id);
            $showplace->update([
                'city_card_id' => $request->city_card_id,
                'type' => $request->type,
                'name' => $request->name,
                'description' => $request->description,
                'photo' => $image
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => new ShowPlaceResource($showplace)
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
    public function destroy($id)
    {
        Showplace::find($id)->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
