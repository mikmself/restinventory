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
            $data = BarangMasuk::with('barang','suplayer','kategori')->where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangMasuk::with('barang','suplayer','kategori')->where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangMasuk::with('barang','suplayer','kategori')->whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangKeluar::with('barang','unitkerja')->where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangKeluar::with('barang','unitkerja')->where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangKeluar::with('barang','unitkerja')->whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalKeluar::with('barang','barangfisik','user','ruang')->whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalPinjam::with('barang','barangfisik','user','ruang')->whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalKembali::with('barang','barangfisik')->where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalKembali::with('barang','barangfisik')->where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalKembali::with('barang','barangfisik')->whereBetween('created_at',[$start,$end])->get();
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
