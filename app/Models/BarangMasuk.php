<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = "barang_masuk";
    protected $fillable = [
        'id_barang',
        'id_suplayer',
        'id_kategori',
        'jumlah',
        'tanggal_masuk',
        'pemesan',
        'penerima',
    ];

    // belongsTo
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }
    public function suplayer(){
        return $this->belongsTo(Suplayer::class,'id_suplayer');
    }
    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori');
    }

}
