<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = "ruang";
    protected $fillable = [
        'nama',
    ];

    // has many
    public function barangModalKeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_ruang');
    }
    public function barangModalPinjam(){
        return $this->hasMany(BarangModalPinjam::class,'id_ruang');
    }
}

