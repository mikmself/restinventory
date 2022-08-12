<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModalPinjam extends Model
{
    protected $table = "barang_modal_pinjam";
    protected $fillable = [
        'id_karyawan',
        'id_barang',
        'id_barang_fisik',
        'jumlah',
        'tanggal_keluar',
        'kegunaan',
        'tanggal_kembali'
    ];

    // belongsTo
    public function karyawan(){
        return $this->belongsTo(Karyawan::class,'id_karyawan');
    }
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
    public function barangfisik(){
        return $this->belongsTo(BarangFisik::class,'id_barang_fisik');
    }
}
