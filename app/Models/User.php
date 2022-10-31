<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//this is new
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    protected $fillable = [
        'firstname', 
        'lastname', 
        'email', 
        'nip',
        'notelp', 
        'level', 
        'token', 
        'password'
    ];
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    // belongsTo
    public function unitkerja(){
        return $this->belongsTo(UnitKerja::class,'id_unitkerja');
    }

    // hasMany
    public function barangkeluar(){
        return $this->hasMany(BarangKeluar::class,'id_user');
    }
    public function barangmodalkeluar(){
        return $this->hasMany(BarangModalKeluar::class,'id_user');
    }
    public function barangmodalpinjam(){
        return $this->hasMany(BarangModalPinjam::class,'id_user');
    }
}
