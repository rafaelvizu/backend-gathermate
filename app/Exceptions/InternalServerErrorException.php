<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InternalServerErrorException extends Exception
{
    //
    public function render($request): JsonResponse
    {
        return response()->json(['message' => 'Internal Server Error'], 500);
    }
}
