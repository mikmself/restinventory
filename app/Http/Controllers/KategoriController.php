<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index(){
        $data = Kategori::paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = Kategori::create([
                'nama_kategori' => $request->input('nama_kategori'),
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
        $data = Kategori::whereId($id)->first();
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
    public function search(Request $request){
        $key = $request->input('key');
        $data = Kategori::where('nama_kategori','LIKE','%' . $key . '%')->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'nama_kategori' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = Kategori::whereId($id)->first();
            if(isset($data)){
                $update = $data->update([
                    'nama_kategori' => $request->input('nama_kategori'),
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
        $data = Kategori::whereId($id)->first();
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
    public function multipleDelete(Request $request){
        $arrayId = $request->arrayId;
        foreach($arrayId as $id){
            Kategori::whereId($id)->delete();
        }
        return response()->json([
            'code' => 1,
            'message' => 'data berhasil dihapus',
            'data' => count($arrayId)
        ]);
    }
}
