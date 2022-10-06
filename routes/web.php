<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/auth/login', 'AuthController@login');
$router->group(['prefix' => '/user/nonauth'], function () use ($router) {
    $router->get('/indexbarang', 'HomeController@indexBarang');
    $router->get('/indexbarangfisik', 'HomeController@indexBarangFisik');
    $router->get('/indexkaryawan', 'HomeController@indexKaryawan');
    $router->get('/indexruang', 'HomeController@indexRuang');
    $router->post('/barangkeluar', 'HomeController@barangKeluar');
    $router->post('/barangmodalkeluar', 'HomeController@barangModalKeluar');
    $router->post('/barangmodalpinjam', 'HomeController@barangModalPinjam');
});

$router->group(['middleware' => ['auth', 'cektoken']], function () use ($router) {
    $router->get('/auth/cektoken', 'AuthController@cekToken');
    $router->group(['prefix' => 'barang'], function () use ($router) {
        $router->get('/','BarangController@index');
        $router->get('/fisik','BarangController@indexBarangFisik');
        $router->get('/indexconfrim','BarangController@indexConfrim');

        $router->get('/indexbarangmasuk','BarangController@indexBarangMasuk');
        $router->post('/barangmasuk','BarangController@barangMasuk');

        $router->get('/indexbarangkeluar','BarangController@indexBarangKeluar');
        $router->post('/barangkeluar','BarangController@barangKeluar');
        $router->get('/confirmbarangkeluar/{id}','BarangController@confirmBarangKeluar');

        $router->get('/indexbarangmodalkeluar','BarangController@indexBarangModalKeluar');
        $router->post('/barangmodalkeluar','BarangController@barangModalKeluar');
        $router->get('/confirmbarangmodalkeluar/{id}','BarangController@confirmBarangModalKeluar');

        $router->get('/indexbarangmodalpinjam','BarangController@indexBarangModalPinjam');
        $router->post('/barangmodalpinjam','BarangController@barangModalPinjam');
        $router->get('/confirmbarangmodalpinjam/{id}','BarangController@confirmBarangModalPinjam');


        $router->get('/indexbarangmodalkembali','BarangController@indexBarangModalKembali');
        $router->post('/barangmodalkembali','BarangController@barangModalKembali');

        $router->post('/importexcel','BarangController@importexcel');
        $router->post('/store','BarangController@store');
        $router->get('/show/{id}','BarangController@show');
        $router->post('/update/{id}','BarangController@update');
        $router->delete('/destroy/{id}','BarangController@destroy');
    });
    $router->group(['prefix' => 'karyawan'], function () use ($router) {
        $router->get('/', 'KaryawanController@index');
        $router->post('/store','KaryawanController@store');
        $router->get('/show/{id}','KaryawanController@show');
        $router->post('/update/{id}','KaryawanController@update');
        $router->delete('/destroy/{id}','KaryawanController@destroy');
    });
    $router->group(['prefix' => 'kategori'], function () use ($router) {
        $router->get('/', 'KategoriController@index');
        $router->post('/store','KategoriController@store');
        $router->get('/show/{id}','KategoriController@show');
        $router->post('/update/{id}','KategoriController@update');
        $router->delete('/destroy/{id}','KategoriController@destroy');
    });
    $router->group(['prefix' => 'pengaturan'], function () use ($router) {
        $router->get('/', 'PengaturanController@index');
        $router->post('/store','PengaturanController@store');
        $router->get('/show/{id}','PengaturanController@show');
        $router->post('/update/{id}','PengaturanController@update');
        $router->delete('/destroy/{id}','PengaturanController@destroy');
    });
    $router->group(['prefix' => 'ruang'], function () use ($router) {
        $router->get('/', 'RuangController@index');
        $router->post('/store','RuangController@store');
        $router->get('/show/{id}','RuangController@show');
        $router->post('/update/{id}','RuangController@update');
        $router->delete('/destroy/{id}','RuangController@destroy');
    });
    $router->group(['prefix' => 'suplayer'], function () use ($router) {
        $router->get('/', 'SuplayerController@index');
        $router->post('/store','SuplayerController@store');
        $router->get('/show/{id}','SuplayerController@show');
        $router->post('/update/{id}','SuplayerController@update');
        $router->delete('/destroy/{id}','SuplayerController@destroy');
    });
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/store','UserController@store');
        $router->get('/show/{id}','UserController@show');
        $router->post('/update/{id}','UserController@update');
        $router->delete('/destroy/{id}','UserController@destroy');
    });
});
