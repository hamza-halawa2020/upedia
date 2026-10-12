<?php

namespace App\Support\Api;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(array $data = [], string $message = 'Done successfully.', int $status = 200): JsonResponse
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
        ], $data), $status);
    }

    public static function error(string $message, array $errors = [], int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
