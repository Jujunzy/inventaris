<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->date('tanggal_penjualan');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barang')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
