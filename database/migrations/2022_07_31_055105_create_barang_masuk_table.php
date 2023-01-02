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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_suplayer')->index()->constrained('suplayer')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kategori')->index()->constrained('kategori')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamp('tanggal_masuk');
            $table->bigInteger('harga');
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
        Schema::dropIfExists('barang_masuk');
    }
};
