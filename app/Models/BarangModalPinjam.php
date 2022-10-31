<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModalPinjam extends Model
{
    protected $table = "barang_modal_pinjam";
    protected $fillable = [
        'id_user',
        'id_barang',
        'id_barang_fisik',
        'id_ruang',
        'tanggal_keluar',
        'kegunaan',
        'tanggal_kembali',
        'confirm'
    ];

    // belongsTo
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
    public function barangfisik(){
        return $this->belongsTo(BarangFisik::class,'id_barang_fisik');
    }
    public function ruang(){
        return $this->belongsTo(Ruang::class,'id_ruang');
    }
}
