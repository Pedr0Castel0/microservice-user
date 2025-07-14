<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    protected function successResponse(string $message, $data = null, int $status = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    protected function errorResponse(string $message, $errors = null, int $status = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        if (config('app.debug') && $errors && is_string($errors)) {
            $response['error'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function validationErrorResponse(string $message, array $errors, int $status = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
