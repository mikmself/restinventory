<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/auth/login', 'AuthController@login');
$router->group(['prefix' => '/user/nonauth'], function () use ($router) {
    $router->get('/indexbarang', 'HomeController@indexBarang');
    $router->get('/indexbarangfisik', 'HomeController@indexBarangFisik');
    $router->get('/indexuser', 'HomeController@indexUser');
    $router->get('/indexunitkerja', 'HomeController@indexUnitKerja');
    $router->get('/indexruang', 'HomeController@indexRuang');
    $router->post('/barangkeluar', 'HomeController@barangKeluar');
    $router->post('/barangmodalkeluar', 'HomeController@barangModalKeluar');
    $router->post('/barangmodalpinjam', 'HomeController@barangModalPinjam');
});

$router->group(['middleware' => ['auth', 'cektoken']], function () use ($router) {
    $router->get('/cektoken/token', 'AuthController@cektoken');
    $router->post('/auth/updatepass', 'AuthController@updatepass');
    $router->get('/indexdashboard', 'HomeController@indexDashboard');
    $router->group(['prefix' => 'barang'], function () use ($router) {
        $router->get('/','BarangController@index');
        $router->get('/fisik','BarangController@indexBarangFisik');
        $router->get('/fisik/{kode}','BarangController@detailBarangFisik');
        $router->get('/indexconfrim','BarangController@indexConfrim');
        $router->post('/search','BarangController@search');

        $router->get('/indexbarangmasuk','BarangController@indexBarangMasuk');
        $router->post('/barangmasuk','BarangController@barangMasuk');

        $router->get('/indexbarangkeluar','BarangController@indexBarangKeluar');
        $router->post('/barangkeluar','BarangController@barangKeluar');
        $router->get('/confirmbarangkeluar/{id}','BarangController@confirmBarangKeluar');

        $router->get('/indexbarangmodalkeluar','BarangController@indexBarangModalKeluar');
        $router->post('/indexbarangmodalkeluar/{id}','BarangController@indexBarangModalKeluarId');
        $router->get('/showBarangModalKeluar/{kode}','BarangController@showBarangModalKeluar');
        $router->post('/barangmodalkeluar','BarangController@barangModalKeluar');
        $router->get('/confirmbarangmodalkeluar/{id}','BarangController@confirmBarangModalKeluar');

        $router->get('/indexbarangmodalpinjam','BarangController@indexBarangModalPinjam');
        $router->post('/barangmodalpinjam','BarangController@barangModalPinjam');
        $router->get('/confirmbarangmodalpinjam/{id}','BarangController@confirmBarangModalPinjam');

        $router->get('/indexbarangmodalkembali','BarangController@indexBarangModalKembali');
        $router->get('/barangmodalkembali/id={id}','BarangController@barangModalKembali');

        $router->post('/importexcel','BarangController@importexcel');
        $router->post('/importbarangmasukhabispakai','BarangController@importBarangMasukHabisPakai');
        $router->post('/importbarangmasukmodal','BarangController@importBarangMasukModal');
        $router->post('/store','BarangController@store');
        $router->get('/show/{id}','BarangController@show');
        $router->post('/update/{id}','BarangController@update');
        $router->delete('/destroy/{id}','BarangController@destroy');
        $router->post('/multipleDelete','BarangController@multipleDelete');
    });
    $router->group(['prefix' => 'kategori'], function () use ($router) {
        $router->get('/', 'KategoriController@index');
        $router->post('/store','KategoriController@store');
        $router->get('/show/{id}','KategoriController@show');
        $router->post('/search','KategoriController@search');
        $router->post('/update/{id}','KategoriController@update');
        $router->delete('/destroy/{id}','KategoriController@destroy');
        $router->post('/multipleDelete','KategoriController@multipleDelete');
    });
    $router->group(['prefix' => 'unitkerja'], function () use ($router) {
        $router->get('/', 'UnitKerjaController@index');
        $router->post('/store','UnitKerjaController@store');
        $router->get('/show/{id}','UnitKerjaController@show');
        $router->post('/search','UnitKerjaController@search');
        $router->post('/update/{id}','UnitKerjaController@update');
        $router->delete('/destroy/{id}','UnitKerjaController@destroy');
        $router->post('/multipleDelete','UnitKerjaController@multipleDelete');
    });
    $router->group(['prefix' => 'pengaturan'], function () use ($router) {
        $router->get('/', 'PengaturanController@index');
        $router->post('/store','PengaturanController@store');
        $router->get('/show/{id}','PengaturanController@show');
        $router->post('/search','PengaturanController@search');
        $router->post('/update/{id}','PengaturanController@update');
        $router->delete('/destroy/{id}','PengaturanController@destroy');
    });
    $router->group(['prefix' => 'ruang'], function () use ($router) {
        $router->get('/', 'RuangController@index');
        $router->post('/store','RuangController@store');
        $router->get('/show/{id}','RuangController@show');
        $router->post('/search','RuangController@search');
        $router->post('/update/{id}','RuangController@update');
        $router->delete('/destroy/{id}','RuangController@destroy');
        $router->post('/multipleDelete','RuangController@multipleDelete');
    });
    $router->group(['prefix' => 'suplayer'], function () use ($router) {
        $router->get('/', 'SuplayerController@index');
        $router->post('/store','SuplayerController@store');
        $router->get('/show/{id}','SuplayerController@show');
        $router->post('/search','SuplayerController@search');
        $router->post('/update/{id}','SuplayerController@update');
        $router->delete('/destroy/{id}','SuplayerController@destroy');
        $router->post('/multipleDelete','SuplayerController@multipleDelete');
    });
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', 'UserController@index');
        $router->post('/store','UserController@store');
        $router->get('/show/{id}','UserController@show');
        $router->post('/search','UserController@search');
        $router->post('/update/{id}','UserController@update');
        $router->delete('/destroy/{id}','UserController@destroy');
        $router->post('/importexcel','UserController@importexcel');
        $router->post('/multipleDelete','UserController@multipleDelete');
    });
    $router->group(['prefix' => 'laporan'], function () use ($router) {
        $router->post('/barangmasuk','LaporanController@laporanBarangMasuk');
        $router->post('/barangkeluar','LaporanController@laporanBarangKeluar');
        $router->post('/barangmodalkeluar','LaporanController@laporanBarangModalKeluar');
        $router->post('/barangmodalpinjam','LaporanController@laporanBarangModalPinjam');
        $router->post('/barangmodalkembali','LaporanController@laporanBarangModalKembali');
    });
});
