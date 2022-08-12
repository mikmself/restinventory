<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suplayer extends Model
{
    protected $table = "suplayer";
    protected $fillable = [
        'nama',
        'alamat',
        'nohp',
    ];

    // hasMany
    public function barangmasuk(){
        return $this->hasMany(BarangMasuk::class,'id_suplayer');
    }
}
