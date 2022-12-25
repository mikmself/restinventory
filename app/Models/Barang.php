<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barang";
    protected $fillable = [
        'id_kategori',
        'nama',
        'stok',
        'satuan',
        'harga'
    ];

    // belongsTo
    public function kategori(){
        return $this->belongsTo(Kategori::class,'id_kategori');
    }

    // hasMany
    public function barangfisik(){
        return $this->hasMany(BarangFisik::class,'id_barang');
    }
    public function barangkeluar(){
        return $this->hasMany(BarangKeluar::class,'id_barang');
    }
    public function barangmodalkeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_barang');
    }
    public function barangmodalpinjam(){
        return $this->hasMany(BarangModalPinjam::class,'id_barang');
    }
    public function barangmodalkembali(){
        return $this->hasMany(BarangModalKembali::class,'id_barang');
    }
    public function barangmasuk(){
        return $this->hasMany(BarangMasuk::class,'id_barang');
    }
}
