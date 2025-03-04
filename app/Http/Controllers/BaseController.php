<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    public function ErrorResponse(Exception | string $error, $errorData = [], $statusCode = 400)
    {
        // check if this http request
        if (!array_key_exists($statusCode, Response::$statusTexts)) :
            $statusCode = Response::HTTP_BAD_REQUEST;
        endif;

        // check is error object or not
        $messageError = $error instanceof Exception ? $error->getMessage() : $error;

        $response = [
            "success" => false,
            "message" => $messageError,
            "code" => $statusCode,
            "data" => $errorData
        ];

        return $response;
    }
}
