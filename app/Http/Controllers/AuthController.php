<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        } else {
            $credentials = $request->only(['nip', 'password']);
            $user = User::where('nip', $request->nip)->first();
            if (isset($user)) {
                $firstname = $user->firstname;
                $lastname = $user->lastname;
                $nip = $user->nip;
                $email = $user->email;
                $unitkerja = $user->unitkerja->nama;
                if (!$token = Auth::attempt($credentials)) {
                    return response()->json(['message' => 'Unauthorized'], 401);
                } else {
                    $user->update([
                        'token' => Str::random(60)
                    ]);
                    $acToken = $user->token;
                    return $this->respondWithToken($token, $firstname,$unitkerja ,$lastname, $nip, $email, $acToken);
                }
            } else {
                $user2 = User::where('email',$request->nip)->first();
                if(isset($user2)){
                    $firstname = $user2->firstname;
                    $lastname = $user2->lastname;
                    $nip = $user2->nip;
                    $email = $user2->email;
                    $unitkerja = $user2->unitkerja->nama;
                    if (!$token = Auth::attempt($credentials)) {
                        return response()->json([
                            'code' => 0,
                            'message' => 'Unauthorized',
                            'data' => []
                        ], 401);
                    } else {
                        $user2->update([
                            'token' => Str::random(60)
                        ]);
                        $acToken = $user2->token;
                        return $this->respondWithToken($token, $firstname,$unitkerja ,$lastname, $nip, $email, $acToken);
                    }
                }else{
                    return response()->json([
                        'code' => 0,
                        'message' => 'nip/email anda tidak ditemukan!',
                        'data' => []
                    ]);
                }
            }
        }
    }
    public function updatepass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        } else {
            $data = User::where('email', $request->input('email'))->first();
            if (isset($data)) {
                if (Hash::check($request->input('oldpassword'), $data->password)) {
                    $update = $data->update([
                        'password' => Hash::make($request->input('newpassword')),
                    ]);
                    if ($update) {
                        return response()->json([
                            'code' => 1,
                            'message' => 'password berhasil diupdate',
                            'data' => $data
                        ]);
                    } else {
                        return response()->json([
                            'code' => 0,
                            'message' => 'password gagal diupdate!',
                            'data' => []
                        ]);
                    }
                } else {
                    return response()->json([
                        'code' => 0,
                        'message' => 'password yang anda masukan salah!',
                        'data' => []
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 0,
                    'message' => 'data tidak ditemukan!',
                    'data' => []
                ]);
            }
        }
    }
    public function cektoken(){
        return response()->json([
            'code' => 1,
            'message' => 'lolos',
            'data' => []
        ]);
        
    }
}
