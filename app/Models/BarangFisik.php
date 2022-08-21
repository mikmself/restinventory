<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangFisik extends Model
{
    protected $table = "barang_fisik";
    protected $fillable = [
        'id_barang',
        'kode',
        'status_pengambilan'
    ];

    // belongsTo
    public function barang(){
        return $this->belongsTo(Barang::class,'id_barang');
    }

    // hasMany
    public function barangmodalkeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_barang_fisik');
    }
    public function barangmodalpinjam(){
        return $this->hasMany(BarangModalKeluar::class,'id_barang_fisik');
    }
    public function barangmodalkembali(){
        return $this->hasMany(BarangModalKembali::class,'id_barang_fisik');
    }
}
