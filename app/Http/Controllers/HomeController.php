<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangFisik;
use App\Models\BarangKeluar;
use App\Models\BarangModalKeluar;
use App\Models\BarangModalPinjam;
use App\Models\Ruang;
use App\Models\UnitKerja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function indexBarang(){
        $data = Barang::with('kategori')->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function indexBarangFisik(){
        $data = BarangFisik::with('barang')->get();
        return response()->json([
            'code' => 1,
            'message' => 'data barang fisik',
            'data' => $data
        ]);
    }
    public function indexUser(){
        $data = User::get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function indexUnitKerja(){
        $data = UnitKerja::get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data
        ]);
    }
    public function indexRuang(){
        $data = Ruang::get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'id_barang' => 'required',
            'jumlah' => 'required',
            'tanggal_keluar' => 'required',
            'kegunaan' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $total = count($request->input('id_barang'));
            $jumlah = $request->input('jumlah');
            $idbarang = $request->input('id_barang');
            $kumpulandata = [];
            $totaljumlah = 0;
            for ($i=0; $i < $total; $i++) {
                $databarang = Barang::whereId($idbarang[$i])->first();
                if($databarang->stok == 0){
                    return response()->json([
                        'code' => 0,
                        'message' => 'stok barang masih kosong!',
                        'data' => []
                    ]);
                }else{
                    $data = BarangKeluar::create([
                        'id_user' => $request->input('id_user'),
                        'id_barang' => $idbarang[$i],
                        'jumlah' => $jumlah[$i],
                        'tanggal_keluar' => $request->input('tanggal_keluar'),
                        'kegunaan' => $request->input('kegunaan')
                    ]);
                    array_push($kumpulandata,$data);
                    $databarang->update([
                        'stok' => $databarang->stok - $jumlah[$i]
                    ]);
                    $totaljumlah += $jumlah[$i];
                }
            }
            if(count($kumpulandata) > 0){
                return response()->json([
                    'code' => 1,
                    'message' => 'operasi barang keluar ' . $totaljumlah . " unit berhasil",
                    'data' => $kumpulandata
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'sesuatu terjadi, operasi barang keluar gagal',
                    'data' => []
                ]);
            }
        }
    }
    public function barangModalKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'id_barang' => 'required',
            'id_barang_fisik' => 'required',
            'id_ruang' => 'required',
            'tanggal_keluar' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $idbarang = $request->input('id_barang');
            $idbarangfisik = $request->input('id_barang_fisik');
            $jumlah = count($idbarangfisik);
            $databarangfisik = [];
            for ($i=0; $i < count($idbarangfisik); $i++) {
                $data = BarangModalKeluar::create([
                    'id_user' => $request->input('id_user'),
                    'id_barang' => $idbarang,
                    'id_barang_fisik' => $idbarangfisik[$i],
                    'id_ruang' => $request->input('id_ruang'),
                    'tanggal_keluar' => $request->input('tanggal_keluar'),
                ]);
                BarangFisik::whereId($idbarangfisik[$i])->update([
                    'status_pengambilan' => 1
                ]);
                array_push($databarangfisik,$data);
            }
            if($data){
                $databarang = Barang::whereId($idbarang)->first();
                $databarang->update([
                    'stok' => $databarang->stok - $jumlah
                ]);
                return response()->json([
                    'code' => 1,
                    'message' => 'operasi barang modal keluar ' . $jumlah . " unit " . $databarang->nama . " berhasil",
                    'data' => $databarangfisik
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'sesuatu terjadi, operasi barang modal keluar gagal',
                    'data' => []
                ]);
            }
        }
    }
    public function barangModalPinjam(Request $request){
        $validator = Validator::make($request->all(),[
            'id_user' => 'required',
            'id_barang' => 'required',
            'id_barang_fisik' => 'required',
            'tanggal_keluar' => 'required',
            'id_ruang' => 'required',
            'kegunaan' => 'required',
            'tanggal_kembali' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $idbarang = $request->input('id_barang');
            $idbarangfisik = $request->input('id_barang_fisik');
            $jumlah = count($idbarangfisik);
            $databarangfisik = [];
            for ($i=0; $i < count($idbarangfisik); $i++) {
                $data = BarangModalPinjam::create([
                    'id_user' => $request->input('id_user'),
                    'id_barang' => $idbarang,
                    'id_barang_fisik' => $idbarangfisik[$i],
                    'id_ruang' => $request->input('id_ruang'),
                    'tanggal_keluar' => $request->input('tanggal_keluar'),
                    'kegunaan' => $request->input('kegunaan'),
                    'tanggal_kembali' => $request->input('tanggal_kembali'),
                ]);
                BarangFisik::whereId($idbarangfisik[$i])->update([
                    'status_pengambilan' => 1
                ]);
                array_push($databarangfisik,$data);
            }
            if($data){
                $databarang = Barang::whereId($idbarang)->first();
                $databarang->update([
                    'stok' => $databarang->stok - $jumlah
                ]);
                return response()->json([
                    'code' => 1,
                    'message' => 'operasi barang modal pinjam ' . $jumlah . " unit " . $databarang->nama . " berhasil",
                    'data' => $databarangfisik
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'sesuatu terjadi, operasi barang modal pinjam gagal',
                    'data' => []
                ]);
            }
        }
    }
    public function indexDashboard(){
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $jumlahbulanan = 0;
        $jumlahtahunan = 0;
        $barangkeluarbulanan = BarangKeluar::whereMonth('created_at',$month)->get();;
        $barangkeluartahunan = BarangKeluar::whereYear('created_at',$year)->get();;
        foreach ($barangkeluarbulanan as $bulanan) {
            $jumlahbulanan += $bulanan->jumlah;
        }
        foreach ($barangkeluartahunan as $tahunan) {
            $jumlahtahunan += $tahunan->jumlah;
        }

        $barangmodalkeluarbulanan = DB::table('barang_modal_keluar')->whereMonth('created_at',$month)->get();;
        $barangmodalkeluartahunan = DB::table('barang_modal_keluar')->whereYear('created_at',$year)->get();;

        $barangmodalpinjambulanan = DB::table('barang_modal_pinjam')->whereMonth('created_at',$month)->get();;
        $barangmodalpinjamtahunan = DB::table('barang_modal_pinjam')->whereYear('created_at',$year)->get();;

        $data = [
            'barang_keluar_bulanan' => $jumlahbulanan,
            'barang_keluar_tahunan' => $jumlahtahunan,
            'barang_modal_keluar_bulanan' => count($barangmodalkeluarbulanan),
            'barang_modal_keluar_tahunan' => count($barangmodalkeluartahunan),
            'barang_modal_pinjam_bulanan' => count($barangmodalpinjambulanan),
            'barang_modal_pinjam_tahunan' => count($barangmodalpinjamtahunan),
        ];
        return response()->json([
            'code' => 1,
            'message' => 'semua laporan data',
            'data' => $data
        ]);
    }
}
