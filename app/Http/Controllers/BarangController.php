<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangFisik;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\BarangModalKeluar;
use App\Models\BarangModalKembali;
use App\Models\BarangModalPinjam;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){
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
    public function indexConfrim(){
        $barangkeluar = BarangKeluar::where('confirm','false')->get();
        $barangmodalkeluar = BarangModalKeluar::where('confirm','false')->get();
        $barangmodalpinjam = BarangModalPinjam::where('confirm','false')->get();
        return response()->json([
            'code' => 1,
            'message' => 'data barang yang belum di confirm',
            'data' => [
                'barangkeluar' => $barangkeluar,
                'barangmodalkeluar' => $barangmodalkeluar,
                'barangmodalpinjam' => $barangmodalpinjam,
            ]
        ]);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'nama' => 'required',
            'satuan' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $data = Barang::create([
                'id_kategori' => $request->input('id_kategori'),
                'nama' => $request->input('nama'),
                'satuan' => $request->input('satuan'),
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
    public function indexBarangMasuk(){
        $data = BarangMasuk::with(['barang','suplayer','kategori'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangMasuk(Request $request){
        $validator = Validator::make($request->all(),[
            'id_barang' => 'required',
            'id_suplayer' => 'required',
            'id_kategori' => 'required',
            'jumlah' => 'required',
            'tanggal_masuk' => 'required',
            'pemesan' => 'required',
            'penerima' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $idbarang = $request->input('id_barang');
            $barang = Barang::whereId($idbarang)->first();
            $jumlah = $request->input('jumlah');
            $kategori = $request->input('id_kategori');
            // kode 1 = barang modal
            // kode 2 = barang habis pakai

            if($kategori == 1){
                // Pengaturan
                $prefix = Pengaturan::where('key','prefix')->pluck('value')->first();
                $infix = Pengaturan::where('key','infix')->pluck('value')->first();
                $suffix = Pengaturan::where('key','suffix')->pluck('value')->first();
                // mencari barang dengan nama yang mirip
                $selectbarangfisik = BarangFisik::where('kode','like','%' .  $barang->nama . '%')->get();
                // Mencari max kode tertingi
                $max = $selectbarangfisik->max('kode');
                // Menacari barang fisik sesuai kode
                $barangfisik = BarangFisik::where('kode',$max)->first();

                $data = BarangMasuk::create([
                    'id_barang' => $idbarang,
                    'id_suplayer' => $request->input('id_suplayer'),
                    'id_kategori' => $request->input('id_kategori'),
                    'jumlah' => $jumlah,
                    'tanggal_masuk' => $request->input('tanggal_masuk'),
                    'pemesan' => $request->input('pemesan'),
                    'penerima' => $request->input('penerima'),
                ]);
                if($barangfisik === null){
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $jumlah; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idbarang,
                                'kode' => $prefix . "." . $barang->nama . "." . str_pad($i, $infix, '0', STR_PAD_LEFT) . "." . $suffix
                            ]);
                            array_push($databarangfisik,$storebarangfisik);
                        }
                        $barang->update([
                            'stok' => $barang->stok + $jumlah
                        ]);
                        return response()->json([
                            'code' => 1,
                            'message' => 'data berhasil dibuat',
                            'data' => [
                                'data_barang_masuk' => $data,
                                'data_barang_fisik' => $databarangfisik
                            ]
                        ]);
                    }else{
                        return response()->json([
                            'code' => 0,
                            'message' => 'data gagal dibuat',
                            'data' => []
                        ]);
                    }
                }else{
                    $explode = explode(".",$barangfisik->kode);
                    $angkainfix = $explode[1];
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $jumlah; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idbarang,
                                'kode' => $prefix . "." . $barang->nama . "." . str_pad($angkainfix+$i, $infix, '0', STR_PAD_LEFT) . "." . $suffix
                            ]);
                            array_push($databarangfisik,$storebarangfisik);
                        }
                        $barang->update([
                            'stok' => $barang->stok + $jumlah
                        ]);
                        return response()->json([
                            'code' => 1,
                            'message' => 'data berhasil dibuat',
                            'data' => [
                                'data_barang_masuk' => $data,
                                'data_barang_fisik' => $databarangfisik
                            ]
                        ]);
                    }else{
                        return response()->json([
                            'code' => 0,
                            'message' => 'data gagal dibuat',
                            'data' => []
                        ]);
                    }
                }
            }else{
                $data = BarangMasuk::create([
                    'id_barang' => $idbarang,
                    'id_suplayer' => $request->input('id_suplayer'),
                    'id_kategori' => $request->input('id_kategori'),
                    'jumlah' => $jumlah,
                    'tanggal_masuk' => $request->input('tanggal_masuk'),
                    'pemesan' => $request->input('pemesan'),
                    'penerima' => $request->input('penerima'),
                ]);
                if($data){
                    $barang->update([
                        'stok' => $barang->stok + $jumlah
                    ]);
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
    }
    public function indexBarangKeluar(){
        $data = BarangKeluar::with(['barang','karyawan'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
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
            $jumlah = $request->input('jumlah');
            $idbarang = $request->input('id_barang');
            $data = BarangKeluar::create([
                'id_karyawan' => $request->input('id_karyawan'),
                'id_barang' => $idbarang,
                'jumlah' => $jumlah,
                'tanggal_keluar' => $request->input('tanggal_keluar'),
                'kegunaan' => $request->input('kegunaan')
            ]);
            if($data){
                $databarang = Barang::whereId($idbarang)->first();
                $databarang->update([
                    'stok' => $databarang->stok - $jumlah
                ]);
                return response()->json([
                    'code' => 0,
                    'message' => 'operasi barang keluar berhasil',
                    'data' => $data
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
    public function confirmBarangKeluar($id){
        $data = BarangKeluar::whereId($id)->update([
            'confirm' => 1
        ]);
        if($data){
            return response()->json([
                'code' => 1,
                'message' => 'data berhasil di confrim',
                'data' => []
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan',
                'data' => []
            ]);
        }
    }
    public function indexBarangModalKeluar(){
        $data = BarangModalKeluar::with(['barang','karyawan','barangfisik','ruang'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
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
            $jumlah = $request->input('jumlah');
            $idbarang = $request->input('id_barang');
            $idbarangfisik = $request->input('id_barang_fisik');
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
                    'code' => 0,
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
    public function confirmBarangModalKeluar($id){
        $data = BarangModalKeluar::where('id_barang',$id)->update([
            'confirm' => 1
        ]);
        if($data){
            return response()->json([
                'code' => 1,
                'message' => 'data berhasil di confrim',
                'data' => []
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan',
                'data' => []
            ]);
        }
    }
    public function indexBarangModalPinjam(){
        $data = BarangModalPinjam::with(['barang','karyawan','barangfisik','ruang'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
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
            $jumlah = $request->input('jumlah');
            $idbarang = $request->input('id_barang');
            $idbarangfisik = $request->input('id_barang_fisik');
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
                    'code' => 0,
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
    public function confirmBarangModalPinjam($id){
        $data = BarangModalPinjam::where('id_barang',$id)->update([
            'confirm' => 1
        ]);
        if($data){
            return response()->json([
                'code' => 1,
                'message' => 'data berhasil di confrim',
                'data' => []
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan',
                'data' => []
            ]);
        }
    }
    public function indexBarangModalKembali(){
        $data = BarangModalKembali::with(['barang','barangfisik'])->get();
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangModalKembali(Request $request){
        $validator = Validator::make($request->all(),[
            'id_barang' => 'required',
            'tanggal_keluar' => 'required',
            'tanggal_kembali' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $idbarang = $request->input('id_barang');
            $tanggalkeluar = $request->input('tanggal_keluar');
            $tanggalkembali = $request->input('tanggal_kembali');
            $barangpinjam = BarangModalPinjam::where([
                ['id_barang',$idbarang],
                ['tanggal_keluar',$tanggalkeluar],
                ['tanggal_kembali',$tanggalkembali]
            ])->get();
            $databarangfisik = [];
            foreach ($barangpinjam as $data) {
                BarangFisik::whereId($data->id_barang_fisik)->update([
                    'status_pengambilan' => 0
                ]);
                BarangModalKembali::create([
                    'id_barang' => $idbarang,
                    'id_barang_fisik' => $data->id_barang_fisik,
                    'tanggal_kembali' => $tanggalkembali
                ]);
                $datastore = BarangFisik::whereId($data->id_barang_fisik)->first();
                array_push($databarangfisik,$datastore);
            }
            $databarang = Barang::whereId($idbarang)->first();
            $update = $databarang->update([
                'stok' => $databarang->stok + count($barangpinjam)
            ]);
            if($update){
                return response()->json([
                    'code' => 1,
                    'message' => 'operasi barang modal kembali berhasil',
                    'data' => [
                        'data_barang' => $databarang,
                        'data_barang_fisik' => $databarangfisik
                    ]
                ]);
            }else{
                return response()->json([
                    'code' => 0,
                    'message' => 'sesuatu terjadi, operasi barnag modal kembali gagal',
                    'data' => []
                ]);
            }
        }
    }
    public function importexcel(Request $request)
    {
        $count = count($request->rows);
        $count -= 1;
        $arraydata = [];
        for ($x = 0; $x <= $count; $x++) {
            $row = $request->rows[$x];
            $data = Barang::create([
                'id_kategori' => $row['id_kategori'],
                'nama' => $row['nama'],
                'satuan' => $row['satuan']
            ]);
            array_push($arraydata,$data);
        }
        return response()->json([
            'code' => 1,
            'message' => 'semua data telah berhasil dibuat',
            'data' => $arraydata
        ]);
    }
    public function show($id){
        $data = Barang::whereId($id)->first();
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
            'id_kategori' => 'required',
            'nama' => 'required',
            'satuan' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'code' => 0,
                'message' => $validator->errors(),
                'data' => []
            ]);
        }else{
            $barang = Barang::whereId($id)->first();
            if(isset($barang)){
                $update = $barang->update([
                    'id_kategori' => $request->input('id_kategori'),
                    'nama' => $request->input('nama'),
                    'satuan' => $request->input('satuan'),
                ]);
                if($update){
                    return response()->json([
                        'code' => 1,
                        'message' => 'data berhasil diupdate',
                        'data' => $barang
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
        $barang = Barang::whereId($id)->first();
        if(isset($barang)){
            $delete = $barang->delete();
            if($delete){
                return response()->json([
                    'code' => 1,
                    'message' => 'data berhasil dihapus',
                    'data' => $barang
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
