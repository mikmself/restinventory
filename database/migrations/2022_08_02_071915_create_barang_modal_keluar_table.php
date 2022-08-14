<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_modal_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->index()->constrained('karyawan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang_fisik')->index()->constrained('barang_fisik')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal_keluar');
            $table->string('ruang');
            $table->boolean('confirm')->default(false);
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
        Schema::dropIfExists('barang_modal_keluar');
    }
};
