<?php

namespace App\Http\Controllers\API\V1\Traits;

trait APIResponse
{
    public function apiResponse($code = 200, $message = null, $errors = null, $data = null)
    {
        $response = [
            "status" => $code,
            "message" => $message
        ];
        if (is_null($errors) && !is_null($data)) {
            $response["data"] = $data;
        } elseif (!is_null($errors) && is_null($data)) {
            $response["errors"] = $errors;
        } else {
            $response["data"] = $data;
            $response["errors"] = $errors;
        }
        return response()->json($response, $code);
    }
}
