<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KaryawanController extends Controller
{
    public function index(){
        $data = Karyawan::with(['unitkerja','user'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'id_unitkerja' => 'required',
            'nama' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = Karyawan::create([
                'id_user' => $request->input('id_user'),
                'id_unitkerja' => $request->input('id_unitkerja'),
                'nama' => $request->input('nama'),
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
        $data = Karyawan::whereId($id)->first();
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
            'id_user' => 'required',
            'id_unitkerja' => 'required',
            'nama' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = Karyawan::whereId($id)->first();
            if(isset($data)){
                $update = $data->update([
                    'id_user' => $request->input('id_user'),
                    'id_unitkerja' => $request->input('id_unitkerja'),
                    'nama' => $request->input('nama'),
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
        $data = Karyawan::whereId($id)->first();
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
    public function importexcel(Request $request)
    {
        $count = count($request->rows);
        $count -= 1;
        $arraydatakaryawan = [];
        $arraydatauser = [];
        for ($x = 0; $x <= $count; $x++) {
            $row = $request->rows[$x];
            $iduser = Str::uuid();

            $datauser = User::create([
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'email' => $row['email'],
                'nip' => $row['nip'],
                'notelp' => $row['notelp'],
                'token' => Str::random(60),
                'password' => Hash::make($row['password'])
            ]);
            array_push($arraydatauser,$datauser);

            $datakaryawan = Karyawan::create([
                'id_user' => $iduser,
                'id_unitkerja' => $row['id_unitkerja'],
                'nama' => $row['firstname'] + " " + $row['lastname']
            ]);
            array_push($arraydatakaryawan,$datakaryawan);
        }
        return response()->json([
            'code' => 1,
            'message' => 'semua data telah berhasil dibuat',
            'data' => $arraydatakaryawan
        ]);
    }

}
