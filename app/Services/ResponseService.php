<?php

namespace App\Services;

class ResponseService
{

    public static function respond($success, $code, $message = null, $data = null, $exeption = null)
    {
        // TODO: tratar a exeption
        return [
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }
}
