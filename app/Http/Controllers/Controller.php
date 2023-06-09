<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\SecurityScheme(
* securityScheme="Bearer",
* type="http",
* scheme="bearer",
* bearerFormat="JWT",
* )
* @OA\Info(
* version="1.0.0",
* title="AbIratoBooks API",
* description="AbIratoBooks API",
* @OA\Contact(
* email="amandine.pda@gmx.com"
* ),
* )
*/
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
