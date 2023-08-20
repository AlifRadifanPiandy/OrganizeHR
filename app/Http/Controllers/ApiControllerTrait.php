<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

trait ApiControllerTrait
{
    private function handleUnauthorized()
    {
        return response()->json([
            'success' => false,
            'message' => 'You do not have the necessary permissions for this action.',
        ], Response::HTTP_UNAUTHORIZED);
    }

    private function handleForbidden()
    {
        return response()->json([
            'success' => false,
            'message' => 'You do not have the necessary permissions for this action.',
        ], Response::HTTP_FORBIDDEN);
    }

    private function handleError(\Exception $e)
    {
        $statusCode = $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $statusCode === Response::HTTP_INTERNAL_SERVER_ERROR ? 'An error occurred.' : $e->getMessage();

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }
}
