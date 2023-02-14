<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModalKeluar extends Model
{
    protected $table = "barang_modal_keluar";
    protected $fillable = [
        'id_unitkerja',
        'id_barang',
        'id_barang_fisik',
        'tanggal_keluar',
        'id_ruang',
        'confirm'
    ];

    // belongsTo
    public function unitkerja(){
        return $this->belongsTo(UnitKerja::class,'id_unitkerja');
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
