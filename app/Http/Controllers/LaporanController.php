<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\BarangModalKeluar;
use App\Models\BarangModalKembali;
use App\Models\BarangModalPinjam;

class LaporanController extends Controller
{
    public function laporanBarangMasuk(Request $request){
        $start = $request->input('start');
        $end = $request->input('end');
        $nama = $request->input('nama');

        $isRequestNama = isset($nama);
        $isRequestTime = isset($start) && isset($end);

        if($isRequestNama && $isRequestTime){
            $data = BarangMasuk::with('barang','suplayer','kategori')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->whereBetween('created_at',[$start,$end])->get();
        }elseif($isRequestNama) {
            $data = BarangMasuk::with('barang','suplayer','kategori')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->get();
        }elseif($isRequestTime){
            $data = BarangMasuk::with('barang','suplayer','kategori')->whereBetween('created_at',[$start,$end])->get();
        }else{
            $data = [];
        }

        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'semua data',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan!',
                'data' => []
            ]);
        }
    }
    public function laporanBarangKeluar(Request $request){
        $start = $request->input('start');
        $end = $request->input('end');
        $nama = $request->input('nama');

        $isRequestNama = isset($nama);
        $isRequestTime = isset($start) && isset($end);

        if($isRequestNama && $isRequestTime){
            $data = BarangKeluar::with('barang','unitkerja')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->whereBetween('created_at',[$start,$end])->get();
        }elseif($isRequestNama) {
            $data = BarangKeluar::with('barang','unitkerja')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->get();
        }elseif($isRequestTime){
            $data = BarangKeluar::with('barang','unitkerja')->whereBetween('created_at',[$start,$end])->get();
        }else{
            $data = [];
        }

        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'semua data',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan!',
                'data' => []
            ]);
        }
    }
    public function laporanBarangModalKeluar(Request $request){
        $start = $request->input('start');
        $end = $request->input('end');
        $nama = $request->input('nama');

        $isRequestNama = isset($nama);
        $isRequestTime = isset($start) && isset($end);

        if($isRequestNama && $isRequestTime){
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->whereBetween('created_at',[$start,$end])->get();
        }elseif($isRequestNama) {
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->get();
        }elseif($isRequestTime){
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->whereBetween('created_at',[$start,$end])->get();
        }else{
            $data = [];
        }

        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'semua data',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan!',
                'data' => []
            ]);
        }
    }
    public function laporanBarangModalPinjam(Request $request){
        $start = $request->input('start');
        $end = $request->input('end');
        $nama = $request->input('nama');

        $isRequestNama = isset($nama);
        $isRequestTime = isset($start) && isset($end);

        if($isRequestNama && $isRequestTime){
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->whereBetween('created_at',[$start,$end])->get();
        }elseif($isRequestNama) {
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->get();
        }elseif($isRequestTime){
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->whereBetween('created_at',[$start,$end])->get();
        }else{
            $data = [];
        }

        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'semua data',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan!',
                'data' => []
            ]);
        }
    }
    public function laporanBarangModalKembali(Request $request){
        $start = $request->input('start');
        $end = $request->input('end');
        $nama = $request->input('nama');

        $isRequestNama = isset($nama);
        $isRequestTime = isset($start) && isset($end);

        if($isRequestNama && $isRequestTime){
            $data = BarangModalKembali::with('barang','barangfisik')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->whereBetween('created_at',[$start,$end])->get();
        }elseif($isRequestNama) {
            $data = BarangModalKembali::with('barang','barangfisik')->whereHas('barang',function($query) use($nama){
                return $query->where('nama',$nama);
            })->get();
        }elseif($isRequestTime){
            $data = BarangModalKembali::with('barang','barangfisik')->whereBetween('created_at',[$start,$end])->get();
        }else{
            $data = [];
        }
        
        if(isset($data)){
            return response()->json([
                'code' => 1,
                'message' => 'semua data',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan!',
                'data' => []
            ]);
        }
    }
}
