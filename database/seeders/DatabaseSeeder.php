<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Pengaturan;
use App\Models\Suplayer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Pengaturan=====================================================================
        Pengaturan::create([
            'key' => 'prefix',
            'value' => 'SMKN1'
        ]);
        Pengaturan::create([
            'key' => 'infix',
            'value' => '6'
        ]);
        Pengaturan::create([
            'key' => 'suffix',
            'value' => 'PURWOKERTO'
        ]);
        //Karyawan========================================================================
        Karyawan::create([
            'nama' => 'Yoga Willy Utomo',
            'status' => 'guru',
            'unit_kerja' => 'Kesiswaan'
        ]);
        //Kategori========================================================================
        Kategori::create([
            'nama_kategori' => 'Barang Modal'
        ]);
        Kategori::create([
            'nama_kategori' => 'Barang Habis Pakai'
        ]);
        //Suplayer========================================================================
        Suplayer::create([
            'nama' => 'Amerta Media',
            'alamat' => 'Sumbang',
            'nohp' => '081327546471'
        ]);
        //Barang==========================================================================
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Kursi',
            'satuan' => 'Buah',
        ]);
        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Penghapus',
            'satuan' => 'Box',
        ]);
        //User=======================================================================
        User::create([
            'name' => 'Muhamad Irga Khoirul Mahfis',
            'email' => 'mikmself@gmail.com',
            'notelp' => '081327546471',
            'level' => 'superadmin',
            'password' => Hash::make('admin123'),
            'token' => Str::random(60)
        ]);
    }
}
