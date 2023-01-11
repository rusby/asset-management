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
        Schema::create('mutasi_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_barang');
            $table->foreignId('id_event');
            $table->enum('status_mutasi', ['Masuk', 'Keluar'])->default('Masuk');
            $table->string('background');
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
        Schema::dropIfExists('mutasi_stocks');
    }
};
