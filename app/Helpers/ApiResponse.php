<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class ApiResponse
{
    public static function createResponse($message = null, $data = null, $statusCode = Response::HTTsP_OK)
    {
        $success = ($statusCode >= 200 && $statusCode < 400);
        return response()->json([
            'status' => $success,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
