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
            $data = BarangMasuk::where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangMasuk::where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangMasuk::whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangKeluar::where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangKeluar::where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangKeluar::whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalKeluar::where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalKeluar::where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalKeluar::whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalPinjam::where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalPinjam::where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalPinjam::whereBetween('created_at',[$start,$end])->get();
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
            $data = BarangModalKembali::where('nama',$nama)->whereBetween('created_at',[$start,$end])->get();
        }
        if($isRequestNama) {
            $data = BarangModalKembali::where('nama',$nama)->get();
        }
        if($isRequestTime){
            $data = BarangModalKembali::whereBetween('created_at',[$start,$end])->get();
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
