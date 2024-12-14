<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('kategori_id');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->timestamps();

            // Menambahkan foreign key constraint untuk supplier_id
            $table->foreign('supplier_id')
                ->references('id')->on('supplier')
                ->onDelete('restrict');

            $table->foreign('kategori_id')
                ->references('id')->on('kategori')
                ->onDelete('restrict');// Menambahkan ON DELETE RESTRICT
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            // Menghapus foreign key constraint
            $table->dropForeign(['supplier_id']);
        });

        // Menghapus tabel barang
        Schema::dropIfExists('barang');
    }
}
