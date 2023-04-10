<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *    schema="CommentSchema",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Comment ID",
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
 *        property="theme_id",
 *        type="integer",
 *        description="Foreign key user",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="comment",
 *        type="string",
 *        description="Комментарий пользователя",
 *        nullable=false,
 *        example="Мы тоже посетили вчера Казань. Было круто!"
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
 *     path="/api/comments",
 *     tags={"Comments"},
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
*               ref="#/components/schemas/CommentSchema"
*            )
*     ),
*       @OA\Response(
*          response=401,
*          description="Unauthenticated",
*      ),     
* )
*
* @OA\Post(
*      path="/api/comments",
*      tags={"Comments"},
*      summary="Добавление новой записи (store())",
*      description="Возвращает новый созданный citycard",
*      @OA\Response(
*          response=201,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/CommentSchema")
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
*      path="/api/comments/{id}",
*      tags={"Comments"},
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
*          @OA\JsonContent(ref="#/components/schemas/CommentSchema")
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
*      path="/api/comments/{id}",
*      tags={"Comments"},
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
*          @OA\JsonContent(ref="#/components/schemas/CommentSchema")
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\JsonContent(ref="#/components/schemas/CommentSchema")
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
*      path="/api/comments/{id}",
*      tags={"Comments"},
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
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $newCity = Comment::create($request->validated());

        return new CommentResource($newCity);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CommentResource(Comment::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
