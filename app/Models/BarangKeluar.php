<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = "barang_keluar";
    protected $fillable = [
        'id_barang',
        'id_unitkerja',
        'jumlah',
        'tanggal_keluar',
        'kegunaan',
        'confirm'
    ];

    // belongsTo
    public function unitkerja(){
        return $this->belongsTo(UnitKerja::class,'id_unitkerja');
    }
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
}
