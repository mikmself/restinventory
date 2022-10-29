<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $data = User::get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'notelp' => 'required',
            'level' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = User::create([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'nip' => $request->input('nip'),
                'notelp' => $request->input('notelp'),
                'level' => $request->input('level'),
                'token' => Str::random(60),
                'password' => Hash::make($request->input('password')),
            ]);
            if($data){
                return response()->json([
                    'code' => 1,
                    'message' => 'data berhasil dibuat',
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'data gagal dibuat',
                    'data' => []
                ]);
            }
        }
    }
    public function show($id){
        $data = User::whereId($id)->first();
        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'detail data dengan id ' . $id,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan',
                'data' => []
            ]);
        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'notelp' => 'required',
            'level' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = User::whereId($id)->first();
            if(isset($data)){
                $update = $data->update([
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'email' => $request->input('email'),
                    'nip' => $request->input('nip'),
                    'notelp' => $request->input('notelp'),
                    'level' => $request->input('level'),
                ]);
                if($update){
                    return response()->json([
                        'code' => 1,
                        'message' => 'data berhasil diupdate',
                        'data' => $data
                    ]);
                }else{
                    return response()->json([
                        'code' => 0,
                        'message' => 'data gagal diupdate',
                        'data' => []
                    ]);
                }
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'data tidak ditemukan',
                    'data' => []
                ]);
            }
        }
    }
    public function destroy($id){
        $data = User::whereId($id)->first();
        if(isset($data)){
            $delete = $data->delete();
            if($delete){
                return response()->json([
                    'code' => 1,
                    'message' => 'data berhasil dihapus',
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'data gagal dihapus',
                    'data' => []
                ]);
            }
        }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'data tidak ditemukan',
                    'data' => []
                ]);
            }
    }
}
