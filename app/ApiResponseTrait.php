<?php

namespace App;

trait ApiResponseTrait
{
    //
    public function apiResponse($data = null, $message = null, $status = null)
    {
        $response = [
            'data' => $data,
            'message' => $message,
            'status' => $status,
        ];

        return response()->json($response, $status);
    }
}
