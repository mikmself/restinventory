<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/auth/login', 'AuthController@login');

$router->group(['middleware' => ['auth', 'cektoken']], function () use ($router) {
    $router->group(['prefix' => 'barang'], function () use ($router) {
        $router->get('/','BarangController@index');
        $router->get('/fisik','BarangController@indexBarangFisik');
        $router->post('/barangmasuk','BarangController@barangMasuk');
        $router->post('/barangkeluar','BarangController@barangKeluar');
        $router->post('/barangmodalkeluar','BarangController@barangModalKeluar');
        $router->post('/barangmodalpinjam','BarangController@barangModalPinjam');
        $router->post('/barangmodalkembali','BarangController@barangModalKembali');
        $router->post('/store','BarangController@store');
        $router->post('/update/{id}','BarangController@update');
        $router->delete('/destroy/{id}','BarangController@destroy');
    });
    $router->group(['prefix' => 'karyawan'], function () use ($router) {
        $router->get('/', 'KaryawanController@index');
        $router->post('/store','KaryawanController@store');
        $router->post('/update/{id}','KaryawanController@update');
        $router->delete('/destroy/{id}','KaryawanController@destroy');
    });
    $router->group(['prefix' => 'kategori'], function () use ($router) {
        $router->get('/', 'KategoriController@index');
        $router->post('/store','KategoriController@store');
        $router->post('/update/{id}','KategoriController@update');
        $router->delete('/destroy/{id}','KategoriController@destroy');
    });
    $router->group(['prefix' => 'pengaturan'], function () use ($router) {
        $router->get('/', 'PengaturanController@index');
        $router->post('/store','PengaturanController@store');
        $router->post('/update/{id}','PengaturanController@update');
        $router->delete('/destroy/{id}','PengaturanController@destroy');
    });
    $router->group(['prefix' => 'suplayer'], function () use ($router) {
        $router->get('/', 'SuplayerController@index');
        $router->post('/store','SuplayerController@store');
        $router->post('/update/{id}','SuplayerController@update');
        $router->delete('/destroy/{id}','SuplayerController@destroy');
    });
});
