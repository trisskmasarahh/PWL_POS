<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id');
            $table->unsignedBigInteger('katagori_id')->index();//indexing untuk foreignkey
            $table->string('barang_kode', 10)->unique();//untuk memastikan tidak ada username yang sama
            $table->string('barang_nama', 100);
            $table->unsignedBigInteger('harga_beli');
            $table->unsignedBigInteger('harga_jual');



            $table->foreign('katagori_id')->references('katagori_id')->on('m_katagori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
