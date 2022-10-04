<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangFisik;
use App\Models\BarangKeluar;
use App\Models\BarangModalKeluar;
use App\Models\BarangModalPinjam;
use Illuminate\Http\Request;
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

    public function barangKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_karyawan' => 'required',
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
            for ($i=0; $i < $total; $i++) {
                $data = BarangKeluar::create([
                    'id_karyawan' => $request->input('id_karyawan'),
                    'id_barang' => $idbarang[$i],
                    'jumlah' => $jumlah[$i],
                    'tanggal_keluar' => $request->input('tanggal_keluar'),
                    'kegunaan' => $request->input('kegunaan')
                ]);
                if($data){
                    $databarang = Barang::whereId($idbarang[$i])->first();
                    array_push($kumpulandata,$data);
                    if($databarang->stok == 0){
                        return response()->json([
                            'code' => 0,
                            'message' => 'stok barang masih kosong!',
                            'data' => []
                        ]);
                    }else{
                        $databarang->update([
                            'stok' => $databarang->stok - $jumlah[$i]
                        ]);
                    }
                }else{
                    return response()->json([
                        'code' => 0,
                        'message' => 'sesuatu terjadi, operasi barang keluar gagal',
                        'data' => []
                    ]);
                }
            }
            return response()->json([
                'code' => 1,
                'message' => 'operasi barang keluar berhasil',
                'data' => $kumpulandata
            ]);
        }
    }
    public function barangModalKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_karyawan' => 'required',
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
                    'id_karyawan' => $request->input('id_karyawan'),
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
                    'message' => 'operasi barang modal keluar berhasil',
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
            'id_karyawan' => 'required',
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
                    'id_karyawan' => $request->input('id_karyawan'),
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
                    'message' => 'operasi barang modal pinjam berhasil',
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
}
