<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    public static function success($data = null, $message = null, $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function error($data = null, $message = null, $code = Response::HTTP_NOT_FOUND)
    {
        return response()->json([
            'status' => false,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function paginate(LengthAwarePaginator $paginator, $data, $message = null, $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl()
            ],
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'path' => $paginator->path(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'message' => $message,
        ], $code);
    }
}
