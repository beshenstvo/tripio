<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** 
* @OA\Get(
*      path="/api/image/public/{id}",
*      tags={"Images"},
*      summary="Выгрузка изображения по id (getImage())",
*      description="Returns image",
*      @OA\Parameter(
*          name="id",
*          description="file name",
*          required=true,
*          in="path",
*          @OA\Schema(
*              type="integer"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Successful operation",
*          @OA\MediaType(
*              mediaType="application/json",
*          )
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
*/
class ImageController extends Controller
{
    public function getImage($path)
    {
        $image = Storage::get($path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $contentType = ($extension === 'svg') ? 'image/svg+xml' : 'image/png';
        return response($image, 200)->header('Content-Type', $contentType);
    }
}
