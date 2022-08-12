<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CekToken
{
    public function handle($request, Closure $next)
    {
        $apikey = $request->header('apikey');
        if (isset($apikey)) {
            $user = User::where('token',$apikey)->first();
            if (isset($user)) {
                return $next($request);
            } else {
                return response()->json([
                    'code' => 0,
                    'message' => 'apikey tidak valid',
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'code' => 0,
                'message' => 'dibutuhkan api key untuk mengakses data',
                'data' => []
            ]);
        }
    }
}
