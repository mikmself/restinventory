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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email',128)->unique();
            $table->string('nip',128)->nullable();
            $table->foreignId('id_unitkerja')->index()->constrained('unit_kerja')->onUpdate('cascade')->onDelete('cascade');
            $table->string('notelp',128)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('level')->default('user');
            $table->string('password');
            $table->string('token');
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
        Schema::dropIfExists('users');
    }
};
