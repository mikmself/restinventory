<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $fillable = [
        'nama_kategori'
    ];

    // hasMany
    public function barang(){
        return $this->hasMany(Barang::class,'id_kategori');
    }
    public function barangmasuk(){
        return $this->hasMany(BarangMasuk::class,'id_kategori');
    }
}
