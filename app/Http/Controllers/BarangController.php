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
use App\Models\Suplayer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){
        $data = Barang::with('kategori')->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function indexBarangFisik(){
        $data = BarangFisik::with('barang')->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'data barang fisik',
            'data' => $data
        ]);
    }
    public function detailBarangFisik($kode){
        $barangfisik = BarangFisik::with('barang')->where('kode',$kode)->first();
        $barangkeluar = BarangModalKeluar::with(['barang','unitkerja','barangfisik','ruang'])->where('id_barang_fisik',$barangfisik->id)->first();
        if (isset($barangkeluar)){
            return response()->json([
                'code' => 1,
                'message' => 'detail data barang fisik',
                'data' => $barangkeluar
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'data tidak ditemukan',
                'data' => []
            ]);
        }
    }
    public function indexConfrim(){
        $barangkeluar = BarangKeluar::where('confirm','false')->latest()->get();
        $barangmodalkeluar = BarangModalKeluar::where('confirm','false')->latest()->get();
        $barangmodalpinjam = BarangModalPinjam::where('confirm','false')->latest()->get();
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
    public function search(Request $request){
        $key = $request->input('key');
        $data = Barang::with('kategori')->where('nama','LIKE','%' . $key . '%')->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
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
    public function indexBarangMasuk(){
        $data = BarangMasuk::with(['barang','suplayer','kategori'])->latest()->paginate(20);
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
            'harga' => 'required',
            'sumber_dana' => 'required'
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
                    'harga' => $request->input('harga'),
                    'sumber_dana' => $request->input('sumber_dana')
                ]);
                if($barangfisik === null){
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $jumlah; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idbarang,
                                'kode' => $prefix . "." . $barang->nama . "." . str_pad($i, $infix, '0', STR_PAD_LEFT) . "." . $suffix,
                                'sumber_dana' => $request->input('sumber_dana')
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
                    $angkainfix = $explode[2];
                    // dd($angkainfix);
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $jumlah; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idbarang,
                                'kode' => $prefix . "." . $barang->nama . "." . str_pad($angkainfix+$i, $infix, '0', STR_PAD_LEFT) . "." . $suffix,
                                'sumber_dana' => $request->input('sumber_dana')
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
                    'harga' => $request->input('harga'),
                    'sumber_dana' => $request->input('sumber_dana')
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
        $data = BarangKeluar::with(['barang','unitkerja'])->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_barang' => 'required',
            'id_unitkerja' => 'required',
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
                $data = BarangKeluar::create([
                    'id_barang' => $idbarang[$i],
                    'id_unitkerja' => $request->input('id_unitkerja'),
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
        $data = BarangModalKeluar::with(['barang','unitkerja','barangfisik','ruang'])->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function indexBarangModalKeluarId(Request $request,$id){
        $start = $request->input('start');
        $end = $request->input('end');
        $isRequestTime = isset($start) && isset($end);
        if($isRequestTime){
            $data = BarangModalKeluar::with(['barang','unitkerja','barangfisik','ruang'])->where('id_barang',$id)->whereBetween('created_at',[$start,$end])->latest()->get();
        }else{
            $data = BarangModalKeluar::with(['barang','unitkerja','barangfisik','ruang'])->where('id_barang',$id)->latest()->get();
        }
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function showBarangModalKeluar($kode){
        $data = BarangModalKeluar::whereHas('barangfisik',function($query) use($kode){
            return $query->where('kode',$kode);
        })->first();
        return response()->json([
            'code' => 1,
            'message' => 'detail data',
            'data' => $data,
        ]);
    }
    public function barangModalKeluar(Request $request){
        $validator = Validator::make($request->all(),[
            'id_unitkerja' => 'required',
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
                    'id_unitkerja' => $request->input('id_unitkerja'),
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
        $data = BarangModalPinjam::with(['barang','unitkerja','barangfisik','ruang'])->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangModalPinjam(Request $request){
        $validator = Validator::make($request->all(),[
            'id_unitkerja' => 'required',
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
                    'id_unitkerja' => $request->input('id_unitkerja'),
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
        $data = BarangModalKembali::with(['barang','barangfisik'])->latest()->paginate(20);
        return response()->json([
            'code' => 1,
            'message' => 'semua data',
            'data' => $data,
        ]);
    }
    public function barangModalKembali($id){
        $data = BarangModalPinjam::whereId($id)->first();
        BarangFisik::whereId($data->id_barang_fisik)->update([
            'status_pengambilan' => 0
        ]);
        BarangModalKembali::create([
            'id_barang' => $data->id_barang,
            'id_barang_fisik' => $data->id_barang_fisik,
            'tanggal_kembali' => $data->tanggal_kembali
        ]);
        $databarangfisik = BarangFisik::whereId($data->id_barang_fisik)->first();
        $databarang = Barang::whereId($data->id_barang)->first();
        $update = $databarang->update([
            'stok' => $databarang->stok + 1
        ]);
        if($update){
            return response()->json([
                'code' => 1,
                'message' => 'barang ' . $databarangfisik->kode . " telah berhasil dikembalikan",
                'data' => [
                    'data_barang' => $databarang,
                    'data_barang_fisik' => $databarangfisik
                ]
            ]);
        }else{
            return response()->json([
                'code' => 0,
                'message' => 'sesuatu terjadi, operasi barang modal kembali gagal',
                'data' => []
            ]);
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
    public function importBarangMasukHabisPakai(Request $request){
        $count = count($request->rows);
        $count -= 1;
        $arraydata = [];
        for ($x = 0; $x <= $count; $x++) {
            $row = $request->rows[$x];
            $barang = Barang::where('nama',$row['nama_barang'])->first();
            $suplayer = Suplayer::where('nama',$row['suplayer'])->first();
            if(!isset($suplayer)){
                Suplayer::create([
                    'nama' => $row['suplayer']
                ]);
            }
            if(!isset($barang)){
                Barang::create([
                    'nama' => $row['nama_barang'],
                    'id_kategori' => 2,
                    'satuan' => $row['satuan'],
                    'stok' => 0
                ]);
            }

            $idSuplayer = Suplayer::where('nama',$row['suplayer'])->first()->id;
            $idBarang = Barang::where('nama',$row['nama_barang'])->first()->id;

            $data = BarangMasuk::create([
                'id_barang' => $idBarang,
                'id_suplayer' => $idSuplayer,
                'id_kategori' => 2,
                'jumlah' => $row['jumlah'],
                'tanggal_masuk' => Carbon::now(),
                'harga' => $row['harga'],
                'sumber_dana' => $row['sumber_dana'],
            ]);
            if($data){
                $databarang = Barang::where('nama',$row['nama_barang'])->first();
                $databarang->update([
                    'stok' => $databarang->stok +  $row['jumlah']
                ]);
                array_push($arraydata,$data);
            }
        }
        return response()->json([
            'code' => 1,
            'message' => 'data berhasil di import',
            'data' => $arraydata
        ]);
    }
    public function importBarangMasukModal(Request $request){
        $count = count($request->rows);
        $count -= 1;
        $arraydata = [];
        for ($x = 0; $x <= $count; $x++) {
            $row = $request->rows[$x];
            $barang = Barang::where('nama',$row['nama_barang'])->first();
            $suplayer = Suplayer::where('nama',$row['suplayer'])->first();
            if(!isset($suplayer)){
                Suplayer::create([
                    'nama' => $row['suplayer']
                ]);
            }
            if(!isset($barang)){
                Barang::create([
                    'nama' => $row['nama_barang'],
                    'id_kategori' => 1,
                    'satuan' => $row['satuan'],
                    'stok' => 0
                ]);
            }

            $idSuplayer = Suplayer::where('nama',$row['suplayer'])->first()->id;
            $idBarang = Barang::where('nama',$row['nama_barang'])->first()->id;

            $data = BarangMasuk::create([
                'id_barang' => $idBarang,
                'id_suplayer' => $idSuplayer,
                'id_kategori' => 1,
                'jumlah' => $row['jumlah'],
                'tanggal_masuk' => Carbon::now(),
                'harga' => $row['harga'],
                'sumber_dana' => $row['sumber_dana'],
            ]);
            if($data){
                $databarang = Barang::where('nama',$row['nama_barang'])->first();
                $databarang->update([
                    'stok' => $databarang->stok +  $row['jumlah']
                ]);
                array_push($arraydata,$data);
                // Pengaturan
                $prefix = Pengaturan::where('key','prefix')->pluck('value')->first();
                $infix = Pengaturan::where('key','infix')->pluck('value')->first();
                $suffix = Pengaturan::where('key','suffix')->pluck('value')->first();
                // mencari barang dengan nama yang mirip
                $selectbarangfisik = BarangFisik::where('kode','like','%' .  $databarang->nama . '%')->get();
                // Mencari max kode tertingi
                $max = $selectbarangfisik->max('kode');
                // Menacari barang fisik sesuai kode
                $barangfisik = BarangFisik::where('kode',$max)->first();

                if($barangfisik === null){
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $row['jumlah']; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idBarang,
                                'kode' => $prefix . "." . $databarang->nama . "." . str_pad($i, $infix, '0', STR_PAD_LEFT) . "." . $suffix,
                                'sumber_dana' => $row['sumber_dana'],
                            ]);
                            array_push($databarangfisik,$storebarangfisik);
                        }
                        $databarang->update([
                            'stok' => $databarang->stok + $row['jumlah']
                        ]);
                    }
                }else{
                    $explode = explode(".",$barangfisik->kode);
                    $angkainfix = $explode[2];
                    if($data){
                        $databarangfisik = [];
                        for ($i=1; $i <= $row['jumlah']; $i++) {
                            $storebarangfisik = BarangFisik::create([
                                'id_barang' => $idBarang,
                                'kode' => $prefix . "." . $barang->nama . "." . str_pad($angkainfix+$i, $infix, '0', STR_PAD_LEFT) . "." . $suffix,
                                'sumber_dana' => $row['sumber_dana'],
                            ]);
                            array_push($databarangfisik,$storebarangfisik);
                        }
                        $databarang->update([
                            'stok' => $databarang->stok + $row['jumlah']
                        ]);
                    }
                }
            }
        }
        return response()->json([
            'code' => 1,
            'message' => 'data berhasil di import',
            'data' => $arraydata
        ]);
    }
    public function multipleDelete(Request $request){
        $arrayId = $request->arrayId;
        foreach($arrayId as $id){
            Barang::whereId($id)->delete();
        }
        return response()->json([
            'code' => 1,
            'message' => 'data berhasil dihapus',
            'data' => count($arrayId)
        ]);
    }
}
