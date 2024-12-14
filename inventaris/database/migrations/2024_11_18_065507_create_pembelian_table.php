<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianTable extends Migration
{
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->date('tanggal_pembelian');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('supplier')->restrictOnDelete();
            $table->foreign('barang_id')->references('id')->on('barang')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelian');
    }
}
