<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = "karyawan";
    protected $fillable = [
        'id_user',
        'id_unitkerja',
        'nama'
    ];

    // belongsTo
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }
    public function unitkerja(){
        return $this->belongsTo(UnitKerja::class,'id_unitkerja');
    }

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
