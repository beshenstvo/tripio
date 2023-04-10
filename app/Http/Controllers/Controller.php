<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     description="Документация API",
 *     version="1.0.0",
 *     title="Tripio"
 * )
 * 
 *  @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 * 
 * @OA\Tag(
 *     name="Cities",
 *     description="Города"
 * )
 * 
 * @OA\Tag(
 *     name="CityCards",
 *     description="Карточка городов"
 * )
 * 
 * @OA\Tag(
 *     name="Comments",
 *     description="Комментарии к темам"
 * )
 * 
 *  @OA\Tag(
 *     name="Hotels",
 *     description="Отели"
 * )
 * 
 *  @OA\Tag(
 *     name="Persons",
 *     description="Гости отеля"
 * )
 * 
 * @OA\Tag(
 *     name="ReadyRoutes",
 *     description="Готовый маршруты"
 * )
 * 
 * @OA\Tag(
 *     name="Requests",
 *     description="Заявки пользователей на экскурсионные услуги"
 * )
 * 
 * @OA\Tag(
 *     name="Reservings",
 *     description="Бронь гостя(связь с отелем через rooms)"
 * )
 * 
 * @OA\Tag(
 *     name="Reviews",
 *     description="Отзывы"
 * )
 * 
 * @OA\Tag(
 *     name="Rooms",
 *     description="Комнаты в отелях"
 * )
 * 
 * @OA\Tag(
 *     name="Services",
 *     description="Предоставляемые услуги гидом"
 * )
 * 
 * @OA\Tag(
 *     name="Showplaces",
 *     description="Достопримечательности"
 * )
 * 
 * @OA\Tag(
 *     name="Themes",
 *     description="Темы обсуждения форума"
 * )
 * 
 *  * @OA\Tag(
 *     name="Images",
 *     description="Получение изображения"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
