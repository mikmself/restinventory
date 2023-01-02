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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_unitkerja')->index()->constrained('unit_kerja')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamp('tanggal_keluar');
            $table->string('kegunaan');
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
        Schema::dropIfExists('barang_keluar');
    }
};
