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
        Schema::create('barang_fisik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang')->index()->constrained('barang')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kode');
            $table->boolean('status_pengambilan')->default(false);
            $table->string('sumber_dana');
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
        Schema::dropIfExists('barang_fisik');
    }
};
