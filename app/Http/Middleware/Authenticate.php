<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    protected $auth;
    // protected $except = [
    //     '/admin/dashboard/master/barang/getspesifikbarangfisik',
    //     '/admin/dashboard/master/barang/getbarangsesuaikategori',
    // ];
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response()->json([
                'code' => 0,
                'message' => 'gagal terauthentikasi',
                'data' => []
            ]);
        }

        return $next($request);
    }
}
