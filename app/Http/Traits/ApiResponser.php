<?php

namespace App\Http\Traits;

trait ApiResponser
{
    protected function success($data = [], string|null $message = null, int $code = 200)
    {
        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error(string|null $message, int $code = 422, $data = null)
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
