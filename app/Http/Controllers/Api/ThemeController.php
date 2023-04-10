<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="ThemesSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Themes ID",
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
 *        property="description",
 *        type="text",
 *        description="Название темы",
 *        nullable=false,
 *        example="Какие места с темой природы посетить в Казани?"
 *    ),
 *     @OA\Property(
 *        property="type",
 *        type="enum",
 *        description="К какому типу относится тема обсуждения",
 *        nullable=false,
 *        example="showplace"
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
 *        description="Date of theme creation",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Date of last updating theme data",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 * 
 * @OA\Get(
 *     path="/api/themes",
 *     tags={"Themes"},
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
*               ref="#/components/schemas/ThemesSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/themes",
*      tags={"Themes"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный theme",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ThemesSchema")
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
*      path="/api/themes/{id}",
*      tags={"Themes"},
*      summary="Вывод конкретной записи (show())",
*      description="Returns theme data",
*      @OA\Parameter(
*          name="id",
*          description="theme id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ThemesSchema")
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
*      path="/api/themes/{id}",
*      tags={"Themes"},
*      summary="Обновление записи (update())",
*      description="Returns updated theme data",
*      @OA\Parameter(
*          name="id",
*          description="Theme id",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(ref="#/components/schemas/ThemesSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/ThemesSchema")
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
*      path="/api/themes/{id}",
*      tags={"Themes"},
*      summary="Удаление записи (delete())",
*      description="Deletes a record and returns no content",
*      @OA\Parameter(
*          name="id",
*          description="Theme id",
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
class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThemeResource::collection(Theme::all());
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
            $data = Theme::create([
                'user_id' => $request->user_id,
                'description' => $request->description,
                'photo' => $image,
                'type' => $request->type
            ]);

            #сохранение изображения
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Created',
                'data' => $data
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
        return new ThemeResource(Theme::findOrFail($id));
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
            $theme = Theme::find($id);
            $theme->update([
                'user_id' => $request->user_id,
                'description' => $request->description,
                'photo' => $image,
                'type' => $request->type
            ]);

            #сохранение изображения
            $oldImageName = Theme::where('id', $id)->get('photo')[0]->photo;
            Storage::disk('public')->put($image, file_get_contents($request->photo));
            
            return response()->json([
                'message' => 'Updated',
                'data' => $theme
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
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
