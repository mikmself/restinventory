<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = "unit_kerja";
    protected $fillable = [
        'nama'
    ];

    public function user(){
        return $this->hasMany(User::class,'id_unitkerja');
    }
    // hasMany
    public function barangkeluar(){
        return $this->hasMany(BarangKeluar::class,'id_unitkerja');
    }
    public function barangmodalkeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_unitkerja');
    }
    public function barangmodalpinjam(){
        return $this->hasMany(BarangModalPinjam::class,'id_unitkerja');
    }
}
