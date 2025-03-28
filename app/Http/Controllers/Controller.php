<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      title="Memories API",
 *      version="2.0.0",
 *      description="Documentação da API usando Swagger"
 * )
 * @OA\Server(
 *      url="http://127.0.0.1:8005",
 *      description="Servidor de Produção"
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT"
 * )
 */



abstract class Controller
{
    //
}
