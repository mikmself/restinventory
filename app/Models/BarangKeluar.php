<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = "barang_keluar";
    protected $fillable = [
        'id_karyawan',
        'id_barang',
        'jumlah',
        'tanggal_keluar',
        'kegunaan'
    ];

    // belongsTo
    public function karyawan(){
        return $this->belongsTo(Karyawan::class,'id_karyawan');
    }
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
}
