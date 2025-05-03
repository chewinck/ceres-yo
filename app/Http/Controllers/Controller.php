<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //

    public function response ($code, $message, $data){
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
