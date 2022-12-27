<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Kategori;
use App\Models\Pengaturan;
use App\Models\Ruang;
use App\Models\Suplayer;
use App\Models\UnitKerja;
use App\Models\User;
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
            'harga' => 500000
        ]);
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Meja',
            'satuan' => 'Unit',
            'harga' => 1500000
        ]);
        Barang::create([
            'id_kategori' => '1',
            'nama' => 'Proyektor',
            'satuan' => 'Unit',
            'harga' => 2000000
        ]);

        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Penghapus',
            'satuan' => 'Box',
            'harga' => 50000
        ]);
        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Spidol',
            'satuan' => 'Box',
            'harga' => 40000
        ]);
        Barang::create([
            'id_kategori' => '2',
            'nama' => 'Kapur',
            'satuan' => 'Box',
            'harga' => 7000
        ]);
        // Unit Kerja=======================================================================
        //1
        UnitKerja::create([
            'nama' => 'IT Support'
        ]);
        //2
        UnitKerja::create([
            'nama' => 'Kepala Sekolah'
        ]);
        //3
        UnitKerja::create([
            'nama' => 'Pendidikan Pancasila dan Kewarganegaraan'
        ]);
        //4
        UnitKerja::create([
            'nama' => 'OTKP'
        ]);
        //5
        UnitKerja::create([
            'nama' => 'BDP'
        ]);
        //6
        UnitKerja::create([
            'nama' => 'BK'
        ]);
        //7
        UnitKerja::create([
            'nama' => 'Matematika'
        ]);
        //8
        UnitKerja::create([
            'nama' => 'Akutansi/PBS'
        ]);
        //9
        UnitKerja::create([
            'nama' => 'Bahasa Indonesia'
        ]);
        //10
        UnitKerja::create([
            'nama' => 'FKK'
        ]);
        //11
        UnitKerja::create([
            'nama' => 'Akuntansi'
        ]);
        //12
        UnitKerja::create([
            'nama' => 'Bahasa Inggris dan Bahasa Asing Lainnya'
        ]);
        //13
        UnitKerja::create([
            'nama' => 'Pendidikan Agama dan Budi Pekerti'
        ]);
        //14
        UnitKerja::create([
            'nama' => 'Sejarah Indonesia'
        ]);
        //15
        UnitKerja::create([
            'nama' => 'DKV'
        ]);
        //16
        UnitKerja::create([
            'nama' => 'PPLG'
        ]);
        //17
        UnitKerja::create([
            'nama' => 'Penjasorkes'
        ]);
        //18
        UnitKerja::create([
            'nama' => 'TJKT'
        ]);
        //19
        UnitKerja::create([
            'nama' => 'Bahasa Jawa'
        ]);
        //20
        UnitKerja::create([
            'nama' => 'Informatika'
        ]);
        //21
        UnitKerja::create([
            'nama' => 'Kepala Tata Usaha'
        ]);
        //22
        UnitKerja::create([
            'nama' => 'Tata Usaha'
        ]);
        //23
        UnitKerja::create([
            'nama' => 'IPAS'
        ]);
        //24
        UnitKerja::create([
            'nama' => 'Staf kurikulum'
        ]);
        //25
        UnitKerja::create([
            'nama' => 'Bendahara BOS'
        ]);
        //26
        UnitKerja::create([
            'nama' => 'Petugas Lab Farm'
        ]);
        //27
        UnitKerja::create([
            'nama' => 'Petugas Perpus'
        ]);
        //28
        UnitKerja::create([
            'nama' => 'Petugas Perpus / UKS'
        ]);
        //29
        UnitKerja::create([
            'nama' => 'Sopir / Inventaris Barang'
        ]);
        //30
        UnitKerja::create([
            'nama' => 'Teknisi'
        ]);
        //31
        UnitKerja::create([
            'nama' => 'Satpam'
        ]);
        //32
        UnitKerja::create([
            'nama' => 'Satpam / Kurir'
        ]);
        //33
        UnitKerja::create([
            'nama' => 'Caraka'
        ]);

        //User=======================================================================
        User::create([
            'firstname' => 'Muhamad Irga',
            'lastname' => 'Khoirul Mahfis',
            'email' => 'mikmself@gmail.com',
            'nip' => '827559966454369898',
            'id_unitkerja' => '1',
            'notelp' => '081327546471',
            'level' => 'admin',
            'password' => Hash::make('admin123'),
            'token' => Str::random(60)
        ]);
        User::create([
            'firstname' => 'Contoh Karyawan',
            'lastname' => 'Tanpa Nip',
            'email' => 'tanpanip@gmail.com',
            'id_unitkerja' => '1',
            'notelp' => '081327546472',
            'level' => 'admin',
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
