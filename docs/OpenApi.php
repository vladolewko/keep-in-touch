<?php
namespace Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="My Laravel API",
 *     version="1.0.0",
 *     description="Опис вашого API"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Основний сервер"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="",
 * )
 */
class OpenApi {

}
