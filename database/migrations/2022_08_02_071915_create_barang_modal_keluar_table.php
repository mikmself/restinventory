<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->foreignId('id_unitkerja')->index()->constrained('unit_kerja')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_barang_fisik')->index()->constrained('barang_fisik')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_ruang')->index()->constrained('ruang')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('tanggal_keluar')->default(DB::raw('CURRENT_TIMESTAMP'));
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
