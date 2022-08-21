<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangModalKembali extends Model
{
    protected $table = "barang_modal_kembali";
    protected $fillable = [
        'id_barang',
        'id_barang_fisik',
        'tanggal_kembali'
    ];
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
    public function barangfisik(){
        return $this->belongsTo(BarangFisik::class,'id_barang_fisik');
    }
}
