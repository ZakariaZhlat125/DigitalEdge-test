<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('successResponse')) {
    function successResponse($message, $data = null, $statusCode = JsonResponse::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}


if (!function_exists('errorResponse')) {
    function errorResponse($message,  $data = null, $statusCode = JsonResponse::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $statusCode);
    }
}
