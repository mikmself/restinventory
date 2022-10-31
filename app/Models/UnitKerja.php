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
}
