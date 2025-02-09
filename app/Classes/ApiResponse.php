<?php

namespace App\Classes;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function send($result = null, $message = null): JsonResponse
    {
        $response = self::response($result, $message);

        return response()->json($response);
    }

    public static function created($result = null, $message = null): JsonResponse
    {
        $response = self::response($result, $message);

        return response()->json($response, 201);
    }

    public static function updated(): JsonResponse
    {
        return response()->json([], 204);
    }

    public static function deleted($result = null, $message = null): JsonResponse
    {
        if (empty($result) && empty($message)) {
            return self::updated();
        }

        return self::send($result, $message);
    }

    public static function badRequest($error = null, $message = null): JsonResponse
    {
        $response = self::errorResponse($error, $message);

        return response()->json($response, 400);
    }

    public static function unauthorized($error = null, $message = null): JsonResponse
    {
        $response = self::errorResponse($error, $message);

        return response()->json($response, 401);
    }

    public static function forbidden($error = null, $message = null): JsonResponse
    {
        $response = self::errorResponse($error, $message);

        return response()->json($response, 403);
    }

    public static function notFound($error = null, $message = null): JsonResponse
    {
        $response = self::errorResponse($error, $message);

        return response()->json($response, 404);
    }

    public static function undefinedError($error = null, $message = null): JsonResponse
    {
        $response = self::errorResponse($error, $message);

        return response()->json($response);
    }

    private static function response($result, $message): array
    {
        $response = ['success' => true];

        if (!empty($result['items'])) {
            $response['items'] = $result['items'];
            unset($result['items']);
        }
        if (!empty($result['item'])) {
            $response['item'] = $result['item'];
            unset($result['item']);
        }
        if (!empty($result))
            $response['data'] = $result;
        if (!empty($message))
            $response['message'] = $message;

        return $response;
    }

    private static function errorResponse($error, $message): array
    {
        $response = ['success' => false];

        if (!empty($error))
            $response['error'] = $error;
        if (!empty($message))
            $response['message'] = $message;

        return $response;
    }
}
