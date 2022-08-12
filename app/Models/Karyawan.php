<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = "karyawan";
    protected $fillable = [
        'nama',
        'status',
        'unit_kerja',
    ];

    // hasMany
    public function barangkeluar(){
        return $this->hasMany(BarangKeluar::class,'id_karyawan');
    }
    public function barangmodalkeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_karyawan');
    }
    public function barangmodalpinjam(){
        return $this->hasMany(BarangModalPinjam::class,'id_karyawan');
    }
}
