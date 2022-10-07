<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Pengaturan;
use App\Models\Ruang;
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
            'value' => 'BP'
        ]);
        Pengaturan::create([
            'key' => 'infix',
            'value' => '6'
        ]);
        Pengaturan::create([
            'key' => 'suffix',
            'value' => 'PWT'
        ]);
        Pengaturan::create([
            'key' => 'logo',
            'value' => '/assets/images/logo/logo.png'
        ]);
        //Karyawan========================================================================
        Karyawan::create([
            'nama' => 'Yoga Willy Utomo',
            'status' => 'guru',
            'unit_kerja' => 'Kesiswaan'
        ]);
        Karyawan::create([
            'nama' => 'Sugeng Priyatno',
            'status' => 'guru',
            'unit_kerja' => 'Kesiswaan'
        ]);
        Karyawan::create([
            'nama' => 'Masriana',
            'status' => 'guru',
            'unit_kerja' => 'Fisika'
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
        Suplayer::create([
            'nama' => 'PT Bakaran Project',
            'alamat' => 'Grendeng',
            'nohp' => '082847284738'
        ]);
        Suplayer::create([
            'nama' => 'PT MIKM Company',
            'alamat' => 'Pasir Kidul',
            'nohp' => '081987384729'
        ]);
        //Barang==========================================================================
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Kursi',
            'satuan' => 'Unit',
        ]);
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Meja',
            'satuan' => 'Unit',
        ]);
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Proyektor',
            'satuan' => 'Unit',
        ]);

        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Penghapus',
            'satuan' => 'Box',
        ]);
        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Spidol',
            'satuan' => 'Box',
        ]);
        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Kapur',
            'satuan' => 'Box',
        ]);
        //User=======================================================================
        User::create([
            'firstname' => 'Muhamad Irga',
            'lastname' => 'Khoirul Mahfis',
            'email' => 'mikmself@gmail.com',
            'notelp' => '081327546471',
            'level' => 'superadmin',
            'password' => Hash::make('admin123'),
            'token' => Str::random(60)
        ]);
        User::create([
            'firstname' => 'Yoga Willy',
            'lastname' => 'Utomo',
            'email' => 'yogawilly@gmail.com',
            'notelp' => '081874263823',
            'level' => 'superadmin',
            'password' => Hash::make('admin123'),
            'token' => Str::random(60)
        ]);
        User::create([
            'firstname' => 'Raafi Gian',
            'lastname' => 'Fauzi',
            'email' => 'raafigian@gmail.com',
            'notelp' => '081293094234',
            'level' => 'superadmin',
            'password' => Hash::make('admin123'),
            'token' => Str::random(60)
        ]);
        //Ruang======================================================================
        Ruang::create([
            'nama' => 'C.2.12'
        ]);
        Ruang::create([
            'nama' => 'C.2.13'
        ]);
        Ruang::create([
            'nama' => 'C.2.14'
        ]);
    }
}
