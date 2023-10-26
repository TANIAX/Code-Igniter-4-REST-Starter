<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="PHP REST TEMPLATE",version="1", description="API documentation")
 * @OA\Server(url="http://localhost:8081", description="Local server")
 * @OA\Server(url="http://localhost:81", description="docker server")
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
interface Swagger
{
}
