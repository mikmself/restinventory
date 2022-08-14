<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangModalKembaliTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_modal_kembali', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang_fisik')->index()->constrained('barang_fisik')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal_kembali');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('barang_modal_kembali');
    }
}
