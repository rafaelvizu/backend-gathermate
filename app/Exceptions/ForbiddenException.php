<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class ForbiddenException extends Exception
{
    //
    public function render($request): JsonResponse
    {
        return response()->json(['message' => 'Forbidden'], 403);
    }
}
