<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function respondWithToken($token, $nama, $email, $acToken)
    {
        return response()->json([
            'code' => 1,
            'message' => "berhasil login",
            'data' => [
                'token' => $token,
                'nama' => $nama,
                'email' => $email,
                'access_token' => $acToken,
                'token_type' => 'bearer',
                'expires_in' => null
            ]
        ], 200);
    }
}
