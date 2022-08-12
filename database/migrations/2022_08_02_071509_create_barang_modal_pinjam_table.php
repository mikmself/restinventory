<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barang_modal_pinjam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->index()->constrained('karyawan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang_fisik')->index()->constrained('barang_fisik')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah');
            $table->date('tanggal_keluar');
            $table->string('kegunaan');
            $table->date('tanggal_kembali');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_modal_pinjam');
    }
};
